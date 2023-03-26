<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideoSolutionRequest;
use App\Http\Requests\UpdateVideoSolutionRequest;
use App\Models\VideoSolution;

class VideoSolutionController extends Controller
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
     * @param  \App\Http\Requests\StoreVideoSolutionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVideoSolutionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VideoSolution  $videoSolution
     * @return \Illuminate\Http\Response
     */
    public function show(VideoSolution $videoSolution)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VideoSolution  $videoSolution
     * @return \Illuminate\Http\Response
     */
    public function edit(VideoSolution $videoSolution)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVideoSolutionRequest  $request
     * @param  \App\Models\VideoSolution  $videoSolution
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVideoSolutionRequest $request, VideoSolution $videoSolution)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VideoSolution  $videoSolution
     * @return \Illuminate\Http\Response
     */
    public function destroy(VideoSolution $videoSolution)
    {
        //
    }
}
