<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePunctuationRequest;
use App\Http\Requests\UpdatePunctuationRequest;
use App\Models\Punctuation;

class PunctuationController extends Controller
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
     * @param  \App\Http\Requests\StorePunctuationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePunctuationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Punctuation  $punctuation
     * @return \Illuminate\Http\Response
     */
    public function show(Punctuation $punctuation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Punctuation  $punctuation
     * @return \Illuminate\Http\Response
     */
    public function edit(Punctuation $punctuation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePunctuationRequest  $request
     * @param  \App\Models\Punctuation  $punctuation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePunctuationRequest $request, Punctuation $punctuation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Punctuation  $punctuation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Punctuation $punctuation)
    {
        //
    }
}
