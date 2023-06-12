<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScoreRequest;
use App\Http\Requests\UpdateScoreRequest;
use App\Models\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $scores = Score::orderBy('id');

        if ($request->search) {
            $scores = Score::search($request->search);
        }

        return view('admin.scores.index', [
            'scores' => $scores->paginate(10)->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.scores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreScoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreScoreRequest $request)
    {
        Score::create([
            'denomination' => $request->denomination,
            'type' => $request->type,
            'points' => $request->points,
        ]);

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'Score created successful!');

        return redirect()->route('scores.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Score  $score
     * @return \Illuminate\Http\Response
     */
    public function show(Score $score)
    {
        return view('admin.scores.show', [
            'score' => $score,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Score  $score
     * @return \Illuminate\Http\Response
     */
    public function edit(Score $score)
    {
        return view('admin.scores.edit', [
            'score' => $score,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateScoreRequest  $request
     * @param  \App\Models\Score  $score
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateScoreRequest $request, Score $score)
    {
        $score->denomination = $request->denomination;
        $score->type = $request->type;
        $score->points = (int) $request->points;
        $score->save();

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'Score updated successful!');

        return redirect()->route('scores.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Score  $score
     * @return \Illuminate\Http\Response
     */
    public function destroy(Score $score)
    {
        $score->delete();

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'Score deleted successful!');

        return redirect()->route('scores.index');
    }
}
