<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChallengeRequest;
use App\Http\Requests\UpdateChallengeRequest;
use App\Models\Category;
use App\Models\Challenge;
use App\Models\Kata;
use App\Models\Mode;
use App\Models\Rank;
use Illuminate\Http\Request;
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
        ]);

        if ($validator->fails()) {
            abort(404);
        }

        if ($request->ajax() && $request->query()) {

            if ($request->query('selected') === 'true') {

                $returnHTML = view('includes.challenges', [
                    'challenges' => $this->getTrainingChallenges(),
                    'selected' => 'none',
                ])->render();

                return response()->json([
                    'success' => true,
                    'challenges' => $returnHTML
                ]);
            }

            $challenges = Challenge::query()->filter($request->query())->get();

            if (count($challenges) > 0) {

                $procesedHTML = view('includes.challenges', [
                    'challenges' => $challenges,
                    'selected' => $request->query('category'),
                ])->render();
            } else {
                $procesedHTML = '<h1 class="flex items-center text-lg dark:text-slate-100 font-semibold justify-center">Challenges Not Found.</h1>';
            }

            return response()->json([
                'success' => true,
                'challenges' => $procesedHTML
            ]);
        }

        return view('challenges.index', [
            'challenges' => $this->getTrainingChallenges(),
        ]);
    }


    protected function getTrainingChallenges()
    {
        $katas = Kata::where(
            'mode_id',
            Mode::where('denomination', request()->path())->first()->id
        )->get();

        return $katas->map(fn($kata) => $kata->challenge)->unique('id');
    }

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
