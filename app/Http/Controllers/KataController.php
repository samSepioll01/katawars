<?php

namespace App\Http\Controllers;

use App\CustomClasses\S3;
use App\CustomClasses\SecurityFilter;
use App\Http\Requests\StoreKataRequest;
use App\Http\Requests\UpdateKataRequest;
use App\Models\Challenge;
use App\Models\Kata;
use App\Models\Language;
use App\Models\Rank;
use App\Models\Solution;
use App\Models\VideoSolution;
use Illuminate\Http\Request;
use Illuminate\Pagination\Cursor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PHPParser\Error;
use PhpParser\ParserFactory;

class KataController extends Controller
{
    private const PER_PAGE = 10;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'ord' => ['nullable', 'string', 'max:10'],
            'category' => ['nullable', 'string', 'max:50'],
            'selected' => ['nullable', 'string', 'max:50'],
            'nextCursor' => ['nullable', 'string', 'max:255'],
        ]);

        $nextCursor = $request->query('nextCursor')
            ? Cursor::fromEncoded($request->query('nextCursor'))
            : null;

        $mykatas = Auth::user()->profile->ownerKatas()
            ->orderBy(
                'id',
                $request->query('ord') ?? 'asc',
            );

        if ($request->query('selected') === 'true') {
            $mykatas = $mykatas->when($request->query('category') ?? false, fn($query) =>
                $query->whereHas('challenge', fn($query) =>
                    $query->whereHas('categories', fn($query) =>
                        $query->where('name', $request->query('category'))
                    )
                )
            );
        }

        $mykatas = $mykatas->cursorPaginate(
            self::PER_PAGE, ['*'], 'cursor', $nextCursor
        );

        if ($mykatas->hasMorePages()) {
            $nextCursor = $mykatas->nextCursor()->encode();
        }

        if ($request->ajax()) {

            if (Auth::user()->profile->ownerKatas->count() > self::PER_PAGE) {
                $returnHTML = view('includes.mykatas', [
                    'mykatas' => $mykatas,
                    'nextCursor' => $nextCursor,
                ])->render();
            } else {
                $returnHTML = '';
            }

            return response()->json([
                'success' => true,
                'html' => $returnHTML,
                'nextCursor' => $nextCursor ?? '',
            ]);
        }



        $lastUpdated = Auth::user()->profile->ownerKatas()
            ->orderBy('created_at', 'asc')
            ?->first()
            ?->created_at;

        if ($lastUpdated) {
            $lastUpdated = $lastUpdated->diffForHumans(now());
            if ($lastUpdated === '1 day before') $lastUpdated = 'yesterday';

            if (Str::of($lastUpdated)->contains(['hour','minute', 'second'])) {
                $lastUpdated = 'today';
            }
        }

        $isAllowed = auth()->user()->hasRole(['admin', 'superadmin'])
            || auth()->user()->profile->rank_id === Rank::where('name', 'black')->first()->id;

        return view('mykatas.index', [
            'mykatas' => $mykatas,
            'totalKatas' => Auth::user()->profile->ownerKatas->count(),
            'lastUpdated' => $lastUpdated,
            'nextCursor' => $nextCursor,
            'isAllowed' => $isAllowed,
        ]);
    }

/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */
public function create()
{
    $testSkel = '<?php
use Tests\TestCase;

class YourTestClassName extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_your_test_class_name($expected, $values)
    {
        $this->assertEquals($expected, yourFunctionSignature($values));
    }

    public function provider()
    {
        return [
            //
        ];
    }
}';
    $functionSignature = 'function yourFunctionSignature($values) {';
    $testClassName = 'YourTestClassName';
    $codeSolution = '<?php
function yourFunctionSignature()
{
    //
}';


    return view('mykatas.create', [
        'testSkel' => $testSkel,
        'functionSignature' => $functionSignature,
        'testClassName' => $testClassName,
        'codeSolution' => $codeSolution,
    ]);
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKataRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKataRequest $request)
    {

        if ($request->ajax()) {

            $categories = $request->input('categories');
            $categories = count($categories) > 3
                ? array_slice($categories, 0, 3)
                : $categories;

            if (!Str::of($request->input('code'))->contains($request->input('testclassname'))) {
                return response()->json([
                    'success' => false,
                    'flash' => 'The Test Class Name field must concordate with class name of your test!',
                ]);
            }

            // Filter and syntax parse the test code.
            $test = trim($request->input('code'));

            $test = str_starts_with($test, '<?php')
                ? $test
                : "<?php $test";

            $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);

            try {
                $parser->parse($test);

            } catch (Error $error) {

                return response()->json([
                    'success' => false,
                    'flash' => "Exists some syntax errors in your test code!",
                ]);
            }

            $test = trim(str_replace('<?php', '', $test));

            // Test de Security Risk of the test passed.
            SecurityFilter::parser($test);


            // Filter and ssyntax parse the solution code.
            $solution = trim($request->input('solution'));

            $solution = str_starts_with($solution, '<?php')
                ? $solution
                : "<?php $solution";

            $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);

            try {
                $parser->parse($solution);

            } catch (Error $error) {

                return response()->json([
                    'success' => false,
                    'message' => "{$error->getMessage()}\n",
                    'flash' => "Exists some syntax errors in your solution code!",
                ]);
            }

            $solution = trim(str_replace('<?php', '', $solution));

            // Test de Security Risk of the solution passed.
            SecurityFilter::parser($solution);

            $testResult = $this->executeTest(
                $request->input('code'),
                $solution,
                $request->input('testclassname')
            );

            if (!$this->checkTestResult($testResult)) {
                return response()->json([
                    'success' => false,
                    'flash' => 'Exists some logic errors in your codes!',
                ]);
            }

            $S3uri_test = S3::generateUploadPath(
                Language::where('name', 'PHP')->first()->name
            );

            Storage::disk('s3')->put($S3uri_test, $request->input('code'));

            $slug = Str::slug($request->input('title'));

            if (Challenge::where('slug', $slug)->exists()) {
                $slug .= Str::random(5);
            }

            $challenge = Challenge::create([
                'url' => url('katas') . "/$slug",
                'slug' => $slug,
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'examples' => $request->input('examples'),
                'notes' => $request->input('notes'),
                'rank_id' => (int) $request->input('rank'),
            ]);

            $challenge->categories()->sync($request->input('categories'));

            $kata = Kata::create([
                'challenge_id' => $challenge->id,
                'owner_id' => Auth::user()->profile->id,
                'language_id' => Language::where('name', 'PHP')->first()->id,
                'mode_id' => (int) $request->input('mode'),
                'uri_test' => $S3uri_test,
                'signature' => $request->input('signature'),
                'testClassName' => $request->input('testclassname'),
            ]);

            $solution = Solution::create([
                'profile_id' => Auth::user()->profile->id,
                'kata_id' => $kata->id,
                'code' => $request->input('solution'),
            ]);

            if ($request->input('videocode')) {

                $videoName = $request->input('videoname')
                    ?: 'Video Solution ' . $challenge->title . Str::random(5);

                VideoSolution::create([
                    'title' => $videoName,
                    'youtube_code' => $request->input('videocode'),
                    'kata_id' => $kata->id,
                ]);
            }

            session()->flash('syncStatus', 'success');
            session()->flash('syncMessage', 'Challenge created succesful!');

            return response()->json(['success' => true]);
        }

        return response()->json([
            'success' => true,
            'code' => $request->code,
        ]);
    }

    /**
     * Check if the test has a valid solution passed by creator.
     */
    protected function executeTest(string $test, string $solution, string $testClassName)
    {
        $testLocalPath = $this->generateTestPath($testClassName);
        $testCommand = $this->generateTestCommand($testLocalPath);

        Storage::disk('local')->put($testLocalPath, $test);
        Storage::disk('local')->append($testLocalPath, $solution);
        exec($testCommand, $testResult);

        Storage::disk('local')->delete($testLocalPath);

        return $testResult;
    }

    /**
     * Check the result of the test and return the message to the user.
     *
     * @param array $testResult
     */
    protected function checkTestResult(array $testResult)
    {
        return substr($testResult[count($testResult) - 1], 0, 2) === 'OK';
    }

    /**
     * Generate the uri path for the resource store in local storage.
     * @param string $testClassName
     * @return string
     */
    protected function generateTestPath(string $testClassName): string
    {
        $user = auth()->user()->id;
        $extension = Language::where('name', 'PHP')->first()->extension;

        return "/katas-tmp/$user/php/$testClassName" . $extension;
    }

    /**
     * Generate the command to execute the test.
     * @param string $testPath
     *
     * @return string
     */
    protected function generateTestCommand(string $testPath): string
    {
        $command = base_path() . '/vendor/bin/phpunit';
        $testPath = storage_path() . '/app' . $testPath;
        return $command . ' ' . $testPath;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kata  $kata
     * @return \Illuminate\Http\Response
     */
    public function show(Kata $kata)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kata  $kata
     * @return \Illuminate\Http\Response
     */
    public function edit(Kata $kata)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKataRequest  $request
     * @param  \App\Models\Kata  $kata
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKataRequest $request, Kata $kata)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kata  $kata
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kata $kata)
    {
        $challenge = $kata->challenge;
        $isOwner = $kata->owner_id === Auth::user()->profile->id;

        if ( $isOwner || Auth::user()->hasRole(['admin', 'superadmin'])) {
            $wasKataDeleted = $kata->delete();
            $wasChallengeDeleted = $challenge->delete();
        }

        if ($wasKataDeleted && $wasChallengeDeleted) {
            session()->flash('syncStatus', 'success');
            session()->flash('syncMessage', 'Challenge deleted succesful!!');
        } else {
            session()->flash('syncStatus', 'error');
            session()->flash('syncMessage', "Can't be possible delete the challenge. Sorry, please try later.");
        }

        return redirect()->back();
    }
}
