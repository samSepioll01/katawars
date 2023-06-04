<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
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
     * @param \App\Models\Challenge $challenge
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Challenge $challenge, Request $request)
    {
        $request->validate([
            'body' => ['required', 'string', 'max:1000'],
            'parent_id' => ['nullable', 'integer'],
        ]);

        $comment = new Comment();
        $comment->challenge_id = $challenge->id;
        $comment->profile_id = Auth::user()->profile->id;
        $comment->body = $request->body;

        if (isset($request->parent_id)) {
            $comment->parent_id = $request->parent_id;
        }

        $comment->save();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Challenge $challenge
     * @param App\Models\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Challenge $challenge, Comment $comment)
    {
        return response()->json([
            'success' => true,
            'body' => $comment->body,
            'action' => "/katas/$challenge->slug/comments/$comment->id",
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Challenge  $challenge
     * @param  \App\Models\Comment  $comment
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Challenge $challenge, Comment $comment, Request $request)
    {
        $request->validate([
            'editcommentbody' => ['required'],
        ]);

        $comment = Comment::where('id', $comment->id)->firstOrFail();
        $comment->body = $request->editcommentbody;
        $comment->save();

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'Comment updated succesfull!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Challenge  $challenge
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Challenge $challenge, Request $request)
    {
        $request->validate([
            'id' => ['integer'],
        ]);

        $comment = $challenge->comments()
            ->where('id', $request->comment)
            ->firstOrFail();

        $this->authorize('delete', $comment);

        $comment->delete();


        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'Comment deleted sucessful!');

        return redirect()->back();
    }
}
