<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModoRequest;
use App\Http\Requests\UpdateModoRequest;
use App\Models\Modo;

class ModoController extends Controller
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
     * @param  \App\Http\Requests\StoreModoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreModoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modo  $modo
     * @return \Illuminate\Http\Response
     */
    public function show(Modo $modo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Modo  $modo
     * @return \Illuminate\Http\Response
     */
    public function edit(Modo $modo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateModoRequest  $request
     * @param  \App\Models\Modo  $modo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateModoRequest $request, Modo $modo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modo  $modo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modo $modo)
    {
        //
    }
}
