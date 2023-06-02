<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResourceRequest;
use App\Http\Requests\UpdateResourceRequest;
use App\Models\Challenge;
use App\Models\Profile;
use App\Models\Resource;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
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
     * @param  \App\Http\Requests\StoreResourceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResourceRequest $request, $slug)
    {
        $request->validate([
            'slug' => ['string', 'max:255'],
        ]);

        $challenge = Challenge::where('slug', $request->slug)->firstOrFail();
        $kata = $challenge->katas->first();

        $resource = new Resource();
        $resource->profile_id = Auth::user()->profile->id;
        $resource->kata_id = $kata->id;
        $resource->title = $request->input('title');
        $resource->url = $request->input('url');
        $resource->description = $request->input('description');
        $resource->save();

        $profile = Auth::User()->profile;
        $profile->honor += Score::where('denomination', 'create resource')->first()->points;
        $profile->save();

        return redirect()->back()->with([
            'tabinstructions' => 'false',
            'tabresources' => 'true',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateResourceRequest  $request
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateResourceRequest $request, $slug, Resource $resource)
    {
        $resource->title = $request->input('title');
        $resource->description = $request->input('description');
        $resource->url = $request->input('url');
        $resource->save();

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'Resource Updated Succesful!');

        return redirect()->back()->with([
            'tabinstructions' => 'false',
            'tabresources' => 'true',
        ]);
    }

    public function getResource(Request $request)
    {
        $resource = Resource::find($request->id);
        return response()->json([
            'success' => true,
            'title' => $resource->title,
            'description' => $resource->description,
            'url' => $resource->url,
            'action' => "/katas/$request->slug/resource/$resource->id",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resource $resource)
    {
        //
    }
}
