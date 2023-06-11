<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResourceRequest;
use App\Http\Requests\UpdateResourceRequest;
use App\Models\Challenge;
use App\Models\Profile;
use App\Models\Resource;
use App\Models\Score;
use App\Models\User;
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

    public function showUserResources(User $user)
    {
        return view('admin.users.resources.index', [
            'user' => $user,
            'resources' => $user->profile->publishedResources()->paginate(20),
        ]);
    }

    public function showUserResource(User $user, Request $request)
    {

        $resource = Resource::find($request->resource);

        return view('admin.users.resources.show', [
            'user' => $user,
            'resource' => $resource,
        ]);
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

    public function edit(Request $request)
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

    public function deleteUserResource(User $user, Request $request)
    {
        $resource = $user->profile->publishedResources
            ->where('id', $request->resource)
            ->first();

        $resource->delete();

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'Resource deleted successful!');

        return redirect()->route('users.resources', [
            'user' => $user,
        ]);
    }

    public function destroyMultipleResources(User $user, Request $request)
    {
        $ids = $request->input('ids');
        Resource::destroy($ids);

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'Resources deleted successful!');

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param App\Models\Challenge $challenge
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Challenge $challenge, Request $request)
    {
        $request->validate([
            'id' => ['integer'],
        ]);

        $resource = $challenge->katas->first()->resources()
            ->where('id', $request->resource)
            ->firstOrFail();

        $this->authorize('delete', $resource);
        $resource->delete();

        $profile = $resource->profile;
        $profile->honor -= Score::where('denomination', 'create resource')->first()->points;
        $profile->save();

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'Resource deleted successful!');

        return redirect()->back()->with([
            'tabresources' => 'true',
            'tabinstructions' => 'false',
            'tabsolutions' => 'false',
        ]);
    }
}
