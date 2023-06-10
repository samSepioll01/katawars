<?php

namespace App\Http\Controllers\Admin;

use App\CustomClasses\CircularCollection;
use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\Kata;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::paginate(10)->withQueryString(),
        ]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $circular = CircularCollection::make(User::all());
        $user = User::findOrFail($id);

        return view('admin.users.show', [
            'user' => $user,
            'previous' => $circular->previous($user),
            'next' => $circular->next($user),
        ]);
    }

    public function showCreatedChallenges(User $user)
    {
        return view('admin.users.challenges.index', [
            'user' => $user,
            'katas' => $user->profile->ownerKatas()->paginate(20),
        ]);
    }

    public function showCreatedChallenge(User $user, $id)
    {
        $challenge = Challenge::findOrFail($id);

        return view('admin.users.challenges.show', [
            'user' => $user,
            'challenge' => $challenge,
            'test_code' => Storage::disk('s3')->get($challenge->katas->first()->uri_test),
        ]);
    }

    /**
     * Show the previous|next user throught id of the showed actually user.
     *
     * @param Request $request
     */
    public function changeUser(Request $request)
    {
        $request->validate([
            'id' => ['integer'],
        ]);

        return redirect()->route(
            'users.show',
            [
                'user' => User::findOrFail($request->id),
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
