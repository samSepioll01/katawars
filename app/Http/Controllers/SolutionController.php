<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Solution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolutionController extends Controller
{
    /**
     * Refresh the solutions for the challenge.
     *
     * @param Request $request
     */
    public function unlockSolutions(Request $request)
    {
        $request->validate([
            'slug' => $request->slug,
        ]);

        $kata = Challenge::where('slug', $request->slug)->firstOrFail();

        $profileSkipped = Auth::user()->profile->skippedKatas();
        $profilePassed = Auth::user()->profile->passedKatas()->get()->contains($kata->id);

        if (!$profilePassed && !$profileSkipped->get()->contains($kata->id)) {
            $profileSkipped->attach($kata->id);
        }

        return redirect()->back()->with([
            'tabsolutions' => 'true',
            'tabinstructions' => 'false',
            'tabresources' => 'false',
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
