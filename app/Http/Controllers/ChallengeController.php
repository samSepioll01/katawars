<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChallengeRequest;
use App\Http\Requests\UpdateChallengeRequest;
use App\Models\Category;
use App\Models\Challenge;
use App\Models\Kata;
use App\Models\Mode;
use Illuminate\Http\Request;

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

        if ($request->ajax() && $request->category) {

            $challenges = Category::where('name', $request->category)->first()->challenges()->get();

            $procesedHTML = view('includes.challenges', [
                'challenges' => $challenges,
                'selected' => $request->category,
            ])->render();

            return response()->json(['success' => true, 'challenges' => $procesedHTML]);
        }


        $route = request()->path();

        if (request()->path() === 'training') {
            $katas = Kata::where(
                'mode_id',
                Mode::where('denomination', request()->path())->first()->id
            )->get();
        }

        if (request()->path() === 'blitz') {
            $katas = Kata::where(
                'mode_id',
                Mode::where('denomination', request()->path())->first()->id
            )->get();
        }

        $challenges = $katas->map(fn($kata) => $kata->challenge)->unique('id');

        return view('challenges.index', ['challenges' => $challenges]);
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
