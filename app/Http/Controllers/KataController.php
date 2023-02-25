<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKataRequest;
use App\Http\Requests\UpdateKataRequest;
use App\Models\Kata;

class KataController extends Controller
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
     * @param  \App\Http\Requests\StoreKataRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKataRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kata  $kata
     * @return \Illuminate\Http\Response
     */
    public function show(Kata $kata)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kata  $kata
     * @return \Illuminate\Http\Response
     */
    public function edit(Kata $kata)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKataRequest  $request
     * @param  \App\Models\Kata  $kata
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKataRequest $request, Kata $kata)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kata  $kata
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kata $kata)
    {
        //
    }
}
