<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModeRequest;
use App\Http\Requests\UpdateModeRequest;
use App\Models\Mode;

class ModeController extends Controller
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
     * @param  \App\Http\Requests\StoreModeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreModeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mode  $mode
     * @return \Illuminate\Http\Response
     */
    public function show(Mode $mode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mode  $mode
     * @return \Illuminate\Http\Response
     */
    public function edit(Mode $mode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateModeRequest  $request
     * @param  \App\Models\Mode  $mode
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateModeRequest $request, Mode $mode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mode  $mode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mode $mode)
    {
        //
    }
}
