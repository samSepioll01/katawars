<?php

namespace App\Http\Controllers;

use App\CustomClasses\CircularCollection;
use App\CustomClasses\SecurityFilter;
use App\Http\Requests\StoreChallengeRequest;
use App\Http\Requests\UpdateChallengeRequest;
use App\Models\Challenge;
use App\Models\Comment;
use App\Models\Kata;
use App\Models\Mode;
use App\Models\Profile;
use App\Models\Resource;
use App\Models\Score;
use App\Models\Solution;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use ParseError;
use PHPParser\Error;
use PhpParser\ParserFactory;

class ChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the Challenges resources for the Training View.
     */
    public function showChallenges(Request $request)
    {
        $this->validateRequest($request->query());

        // Dont respect the filters.
        if ($request->query('searcher') === 'true') {

            if (!$request->query('search')) {
                $challenges = $this->filteredChallenges()->get();
            } else {
                $challenges = Challenge::search($request->query('search'))->get();
                $challenges = $challenges->filter(
                    fn($challenge) => $challenge->katas->first()->mode_id !== 2
                );
            }

            if ($challenges->count()) {

                $returnHTML = $this->renderView(
                    'includes.challenges',
                    $challenges,
                );

            } else {
                $returnHTML = $this->getMessageNotAvailable();
            }

            return response()->json([
                'success' => true,
                'challenges' => $returnHTML,
            ]);
        }

        $ord = $request->query('sort') === 'asc' ? 'asc' : 'desc';

        // Where user apply filters
        if ($request->ajax() && $request->query()) {

            // Case when the filter for category is active.
            if ($request->query('selected') === 'true') {

                // Disable selected styles for category and recovery all initial records.
                $returnHTML = $this->renderView(
                    'includes.challenges',
                    $this->filteredChallenges([], $ord)->get(),
                );

                return response()->json([
                    'success' => true,
                    'challenges' => $returnHTML
                ]);
            }

            // Apply all filters actives.
            $challenges = $this->filteredChallenges($request->query(), $ord)->get();

            $passedChallenges = $this->getPassedChallenges();

            // Case filter completed or not.
            if ($request->query('status') === 'true') {
                $challenges = $challenges->intersect($passedChallenges);
            }

            if ($request->query('status') === 'false') {
                $challenges = $challenges->diff($passedChallenges);
            }

            $challenges = $challenges->sortBy('id', SORT_REGULAR, $ord === 'asc');

            // Manage case in that no challenges found for the applicate filter.
            if (count($challenges) > 0) {

                $procesedHTML = $this->renderView(
                    'includes.challenges',
                    $challenges,
                    $request->query('category')
                );

            } else {

                $procesedHTML = $this->getMessageNotAvailable();
            }

            return response()->json([
                'success' => true,
                'challenges' => $procesedHTML,
            ]);
        }

        $selected = $request->query('category') ?: null;

        // Resources returned the first time that call the view.
        return view('challenges.index', [
            'challenges' => $this->filteredChallenges($request->query(), $ord)->get(),
            'selected' => $selected,
        ]);
    }

    /**
     * Get the the challenges applicate the filters.
     *
     * @param
     */
    protected function filteredChallenges(
        array $filters = [],
        string $ord = 'asc',
        string $mode = 'training',
    )
    {
        return Challenge::query()->filter($filters,
            [
                Mode::where('denomination', $mode)->first()->id,
            ],
        )->orderBy('id', $ord);
    }

    /**
     * Validate the params of the incomming request.
     */
    protected function validateRequest($queryBag)
    {
        $validator = Validator::make($queryBag, [
            'category' => ['string', 'max:255'],
            'rank' => ['string', 'max:255'],
            'selected' => ['string', 'max:10'],
            'sort' => ['string', 'max:10'],
            'status' => ['string', 'max:10'],
        ]);

        if ($validator->fails()) {
            abort(404);
        }
    }

    /**
     * Set default message when not find challenges with the constaints.
     */
    protected function getMessageNotAvailable()
    {
        return '<h1 class="flex items-center text-lg dark:text-slate-100 font-semibold justify-center">Challenges not availables yet.</h1>';
    }

    /**
     * Render the view with the news records.
     *
     * @param string $routeView
     * @param mixed $challenges
     * @param string $category
     *
     * @return string
     */
    protected function renderView(
        string $routeView,
        mixed $challenges,
        string $category = 'none'
    )
    {
        return view($routeView, [
            'challenges' => $challenges,
            'selected' => $category,
        ])->render();
    }

    /**
     * Get the challenges that has been passed succesfully.
     */
    protected function getPassedChallenges(): Collection
    {
        $passedKatas = Profile::find(Auth::user()->id)->passedKatas()->get();
        $passedKatas = $passedKatas->where('mode_id', 1)->unique('challenge_id');
        return $passedKatas->map(fn($kata) => $kata->challenge);
    }

    /**
     * Show the main page for the Challenges throught the slug.
     */
    public function showKataMainPage(Request $request)
    {
        $request->validate([
            'slug' => ['string', 'max:255', 'alpha_dash', 'unique:challenge'],
        ]);

        $katas = Kata::where('mode_id', 1)
            ->where('language_id', 1)
            ->orderBy('id')
            ->get();

        $challenges = $katas->map(fn($kata) => $kata->challenge);

        $challenge = $challenges->where('slug', $request->slug)
            ->firstOrFail();

        $circular = CircularCollection::make($challenges);

        $resources = Resource::allLikesCount()
            ->where('kata_id', $challenge->katas->first()->id);

        $solutions = Solution::allLikesCount()
            ->where('kata_id', $challenge->katas->first()->id);

        $isPassedKata = Auth::user()->profile->passedKatas
            ->contains($challenge->katas->first()->id);

        $isSkippedKata = Auth::user()->profile->skippedKatas
            ->contains($challenge->katas->first()->id);

        $comments = Comment::allLikesCount()
            ->where('challenge_id', $challenge->id)
            ->whereNull('parent_id');

        return view('katas.main-page', [
            'challenge' => $challenge,
            'owner' => $challenge->katas()->first()->owner->user,
            'signature' => $challenge->katas()->first()->signature,
            'score' => Score::where('denomination', 'training')->first()->points,
            'previous' => $circular->previous($challenge)->id,
            'next' => $circular->next($challenge)->id,
            'resources' => $resources,
            'solutions' => $solutions,
            'isPassedKata' => $isPassedKata,
            'isSkippedKata' => $isSkippedKata,
            'comments' => $comments,
        ]);
    }

    /**
     * Show the previous challenge throught id of the showed actually challenge.
     *
     * @param Request $request
     */
    public function changeChallenge(Request $request)
    {
        $request->validate([
            'id' => ['integer'],
        ]);

        return redirect()->route(
            'katas.main-page',
            [
                'slug' => Challenge::find($request->id)->slug,
            ]
        );
    }

    /**
     * Show the next challenged to complete.
     */
    public function showNextChallengeAvailable()
    {
        $profile = Auth::user()->profile;
        $passedKatas = $profile->passedKatas()->get();
        $skippedKatas = $profile->skippedKatas()->get();

        $trainingKatas = Mode::where('denomination', 'training')->first()->katas;
        $skippedPassedKatas = $passedKatas->merge($skippedKatas);
        $katasAvailables = $trainingKatas->diff($skippedPassedKatas);

        if ($katasAvailables->count()) {
            $nextChallenge = $katasAvailables->random()->challenge;
            return redirect()->route('katas.main-page', ['slug' => $nextChallenge->slug]);
        }

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'You have completed all the available challenges. Create then yourself or wait for the community to add them.');

        return redirect()->back();
    }

    /**
     * Check thats the user code is correct.
     *
     * @param Request $request
     */
    public function verifyKata(Request $request)
    {
        $request->validate([
            'slug' => ['string', 'max:255', 'required', 'alpha_dash'],
            'code' => ['string', 'required'],
        ]);

        if ($request->ajax()) {

            $code = trim($request->input('code'));
            $code = str_starts_with($code, '<?php')
                ? $code
                : "<?php $code";

            $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);

            try {
                $parser->parse($code);

            } catch (Error $error) {

                return response()->json([
                    'success' => false,
                    'message' => "{$error->getMessage()}\n",
                    'flash' => "Exists some syntax errors parse your code and try it again!",
                ]);
            }

            $code = trim(str_replace('<?php', '', $code));

            SecurityFilter::parser($code);

            $kata = Challenge::where('slug', $request->slug)
                ->firstOrFail()->katas()->first();

            $testResult = $this->executeTest($code, $kata);

            if ($this->checkTestResult($testResult)) {

                $profile = Auth::user()->profile;

                $isPassedKata = $profile->passedKatas()->get()->contains($kata->id);
                $isSkippedKata = $profile->skippedKatas()->get()->contains($kata->id);

                // If the user not passed the kata previously sum exp
                // and save the solution.
                if (!$isPassedKata && !$isSkippedKata) {

                    $profile->passedKatas()->attach($kata->id, [
                        'code' => $code,
                    ]);

                    $profile->exp = Score::where('denomination', 'training')
                        ->first()->points;
                    $profile->save();

                    $owner = $kata->owner;
                    $owner->honor += Score::where('denomination', 'passed kata to owner')
                        ->first()->points;
                    $owner->save();
                }

                $returnHTML = view('includes.katapanel', [
                    'passed' => true,
                    'testsCompleted' => trim(str_replace('.', '', $testResult[2])),
                    'asserts' => $testResult[count($testResult) - 1],
                ])->render();

                $solutions = view('includes.solution', [
                    'solutions' => Solution::allLikesCount()->where('kata_id', $kata->id),
                    'challenge' => $kata->challenge,
                ])->render();

                return response()->json([
                    'success' => true,
                    'message' => $returnHTML,
                    'progressbar' => $profile->getProfileProgress() . '%',
                    'solutions' => $solutions,
                ]);
            }

            $returnHTML = view('includes.katapanel', [
                'passed' => false,
                'errorLines' => $this->getErrorLines($testResult),
            ])->render();

            return response()->json([
                'success' => false,
                'message' => $returnHTML,
                'flash' => 'Exists some logic errors in your code!',
            ]);
        }
    }

    /**
     * Execute the test against the user code.
     *
     * @param string $code
     * @param Kata $kata
     *
     * @return array
     */
    protected function executeTest(string $code, Kata $kata)
    {
        $testCode = Storage::disk('s3')->get($kata->uri_test);
        $testLocalPath = $this->generateTestPath($kata);

        $userCode = $this->filterUserSignature(
            $code,
            $this->getMethodName($kata->signature),
        );

        $testCommand = $this->generateTestCommand($testLocalPath);

        // Generate the test file
        Storage::disk('local')->put($testLocalPath, $testCode);

        // Add user code to the test
        Storage::disk('local')->append($testLocalPath, $userCode);

        exec($testCommand, $testResult); // Run test

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
     * Get the error lines for be showed to the user.
     *
     * @param array $testResult
     * @return string
     */
    protected function getErrorLines(array $testResult): array
    {
        $numLines = count($testResult);
        $numFailed = substr_count($testResult[2], 'F');
        $lines[] = 'Tests Run: ' . trim(str_replace('F', '', $testResult[2]));
        $lines[] = $testResult[$numLines - 2];
        $lines[] = $testResult[$numLines - 1];
        $lines[] = $testResult[6];
        $founded = 0;

        for ($i = 0; $i < $numLines && $founded < $numFailed; $i++) {

            if (str_starts_with($testResult[$i], $founded + 1)) {
                $lines[] = explode(' ', $testResult[$i])[0] . " {$testResult[$i + 1]}";
                $founded++;
            }
        }

        return $lines;
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
     * Generate the uri path for the resource store in local storage.     *
     * @param Kata $kata
     *
     * @return string
     */
    protected function generateTestPath(Kata $kata): string
    {
        $user = auth()->user()->id;
        $language = strtolower($kata->language->name);
        $extension = $kata->language->extension;
        $testClassName = $kata->testClassName;

        return "/katas-tmp/$user/$language/$testClassName" . $extension;
    }

    /**
     * Replace the user function name for the original function name.
     *
     * @param string $code
     * @param string $originalMethodName
     * @return string
     */
    protected function filterUserSignature(
        string $code, string $originalMethodName
    ): string
    {
        $start = strpos($code, ' ') + 1;
        $length = strpos($code, '(');
        return substr_replace($code, $originalMethodName, $start, $length - $start);
    }

    /**
     * Get the method name for the test throught the kata signature field.
     *
     * @param string $signature
     * @return string
     */
    protected function getMethodName(string $signature): string
    {
        $start = strpos($signature, ' ') + 1;
        $length = strpos($signature, '(');

        return substr($signature, $start, $length - $start);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreChallengeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChallengeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function show(Challenge $challenge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function edit(Challenge $challenge)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateChallengeRequest  $request
     * @param  \App\Models\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChallengeRequest $request, Challenge $challenge)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function destroy(Challenge $challenge)
    {
        //
    }
}
