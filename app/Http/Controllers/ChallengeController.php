<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChallengeRequest;
use App\Http\Requests\UpdateChallengeRequest;
use App\Models\Category;
use App\Models\Challenge;
use App\Models\Kata;
use App\Models\Mode;
use App\Models\Profile;
use App\Models\Rank;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    public function showChallenges(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => ['string', 'max:255'],
            'rank' => ['string', 'max:255'],
            'selected' => ['string', 'max:10'],
            'sort' => ['string', 'max:10'],
            'status' => ['string', 'max:10'],
        ]);

        if ($validator->fails()) {
            abort(404);
        }

        if ($request->query('searcher') === 'true') {

            $challenges = Challenge::search($request->query('search'))->get();

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

        if ($request->ajax() && $request->query()) {

            if ($request->query('selected') === 'true') {

                $returnHTML = $this->renderView(
                    'includes.challenges',
                    Challenge::query()->filter([],
                        [
                            Mode::where('denomination', 'training')->first()->id,
                        ],
                    )->orderBy('id', $ord)->get(),
                );

                return response()->json([
                    'success' => true,
                    'challenges' => $returnHTML
                ]);
            }

            $challenges = Challenge::query()->filter(
                $request->query(),
                [
                    Mode::where('denomination', 'training')->first()->id
                ],
            )->get();

            $passedChallenges = $this->getPassedChallenges();

            if ($request->query('status') === 'true') {
                $challenges = $challenges->intersect($passedChallenges);
            }

            if ($request->query('status') === 'false') {
                $challenges = $challenges->diff($passedChallenges);
            }

            $challenges = $challenges->sortBy('id', SORT_REGULAR, $ord === 'asc');

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

        return view('challenges.index', [
            'challenges' => Challenge::query()->filter([],
                [
                    Mode::where('denomination', 'training')->first()->id,
                ],
            )->orderBy('id', $ord)->get(),
        ]);
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
        $challenge = Challenge::where('slug', $request->slug)->first();

        return view('katas.main-page', ['challenge' => $challenge]);
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
