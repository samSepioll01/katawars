<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKataWayRequest;
use App\Http\Requests\UpdateKataWayRequest;
use App\Models\KataWay;

class KataWayController extends Controller
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
     * @param  \App\Http\Requests\StoreKataWayRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKataWayRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KataWay  $kataWay
     * @return \Illuminate\Http\Response
     */
    public function show(KataWay $kataWay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KataWay  $kataWay
     * @return \Illuminate\Http\Response
     */
    public function edit(KataWay $kataWay)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKataWayRequest  $request
     * @param  \App\Models\KataWay  $kataWay
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKataWayRequest $request, KataWay $kataWay)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KataWay  $kataWay
     * @return \Illuminate\Http\Response
     */
    public function destroy(KataWay $kataWay)
    {
        //
    }
}
