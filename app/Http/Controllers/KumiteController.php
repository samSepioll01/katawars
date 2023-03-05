<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKumiteRequest;
use App\Http\Requests\UpdateKumiteRequest;
use App\Models\Kumite;

class KumiteController extends Controller
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
     * @param  \App\Http\Requests\StoreKumiteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKumiteRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kumite  $kumite
     * @return \Illuminate\Http\Response
     */
    public function show(Kumite $kumite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kumite  $kumite
     * @return \Illuminate\Http\Response
     */
    public function edit(Kumite $kumite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKumiteRequest  $request
     * @param  \App\Models\Kumite  $kumite
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKumiteRequest $request, Kumite $kumite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kumite  $kumite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kumite $kumite)
    {
        //
    }
}
