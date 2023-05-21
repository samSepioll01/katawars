<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChallengeRequest;
use App\Http\Requests\UpdateChallengeRequest;
use App\Models\Challenge;
use App\Models\Mode;
use App\Models\Profile;
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

        // Resources returned the first time that call the view.
        return view('challenges.index', [
            'challenges' => $this->filteredChallenges([], $ord)->get(),
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
        $challenge = Challenge::where('slug', $request->slug)->first();

        return view('katas.main-page', [
            'challenge' => $challenge,
            'owner' => $challenge->katas()->first()->owner->user,
            'signature' => $challenge->katas()->first()->signature,
        ]);
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
