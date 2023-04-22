<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHelpRequest;
use App\Http\Requests\UpdateHelpRequest;
use App\Models\Help;

class HelpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('help', [
            'sections' => Help::distinct()->pluck('section'),
            'helps' => Help::all(),
            'updatedAt' => Help::orderBy('updated_at')->first()->updated_at,
        ])->render();
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
     * @param  \App\Http\Requests\StoreHelpRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHelpRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Help  $help
     * @return \Illuminate\Http\Response
     */
    public function show(Help $help)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Help  $help
     * @return \Illuminate\Http\Response
     */
    public function edit(Help $help)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHelpRequest  $request
     * @param  \App\Models\Help  $help
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHelpRequest $request, Help $help)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Help  $help
     * @return \Illuminate\Http\Response
     */
    public function destroy(Help $help)
    {
        //
    }
}
