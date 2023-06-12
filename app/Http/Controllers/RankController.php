<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRankRequest;
use App\Http\Requests\UpdateRankRequest;
use App\Models\Rank;
use Illuminate\Http\Request;

class RankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ranks = Rank::orderBy('id');

        if ($request->search) {
            $ranks = Rank::search($request->search);
        }

        return view('admin.ranks.index', [
            'ranks' => $ranks->paginate(10)->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.ranks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRankRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRankRequest $request)
    {
        Rank::create([
            'name' => $request->name,
            'level_up' => $request->levelup,
        ]);

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'Rank created successful!');

        return redirect()->route('ranks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rank  $ranK
     * @return \Illuminate\Http\Response
     */
    public function show(Rank $rank)
    {
        return view('admin.ranks.show', [
            'rank' => $rank,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rank  $rank
     * @return \Illuminate\Http\Response
     */
    public function edit(Rank $rank)
    {
        return view('admin.ranks.edit', [
            'rank' => $rank,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRankRequest  $request
     * @param  \App\Models\Rank  $rank
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRankRequest $request, Rank $rank)
    {
        $rank->name = $request->name;
        $rank->level_up = $request->levelup;
        $rank->save();

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'Rank updated successful!');

        return redirect()->route('ranks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rank  $rank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rank $rank)
    {
        $rank->delete();

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'Rank deleted successful!');

        return redirect()->route('ranks.index');
    }
}
