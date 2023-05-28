<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FavoritesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'ord' => ['string', 'max:10'],
        ]);

        $favorites = Auth::user()->profile->favorites()->where('is_active', true);

        if ($request->ajax()) {

            $favorites = $favorites->orderBy(
                'id',
                $request->query('ord'),
            )->get();

            $returnHTML = view('includes.favorites', [
                'favorites' => $favorites
            ])->render();

            return response()->json([
                'success' => true,
                'html' => $returnHTML,
            ]);
        }

        $lastUpdated = Auth::user()->profile->favorites()
            ->orderBy('created_at', 'desc')
            ?->first()
            ?->created_at;

        if ($lastUpdated) {
            $lastUpdated = $lastUpdated->diffForHumans(now());
            if ($lastUpdated === '1 day before') $lastUpdated = 'yesterday';

            if (Str::of($lastUpdated)->contains(['hour','minute', 'second'])) {
                $lastUpdated = 'today';
            }
        }

        return view('katas.favorites', [
            'favorites' => $favorites->get(),
            'lastUpdated' => $lastUpdated,
            'totalFavorites' => Auth::user()->profile->favorites()
                ->where('is_active', true)->count(),
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
        $request->validate([
            'id' => ['integer'],
        ]);

        $solution = Auth::user()->profile->solutions()
            ->where('kata_id', $request->id)
            ->firstOrFail();

        if ($favorite = $solution->favorite) {

            $favorite->update(['is_active' => !$favorite->is_active]);

        } else {

            $profile = Auth::user()->profile;

            $favorite = Favorite::create([
                'profile_id' => $profile->id,
                'solution_id' => $solution->id,
                'is_active' => true,
            ]);

            // Generate profile record fro the score type.
            if ($favorite->createScoreRecord($profile->id)) {
                // Assign Score for the owner of resource.
                $favorite->assignScore();
            }

        }

        return response()->json([
            'success' => true,
        ]);

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
    public function destroy(Request $request, $id)
    {
        $request->validate([
            'id' => ['integer'],
        ]);

        if ($request->ajax()) {

            $favorites = Auth::user()->profile->favorites();
            $favorite = $favorites->where('id', $id)->firstOrFail();
            $favorite->is_active = false;
            $favorite->save();

            return response()->json(
                [
                    'success' => true,
                    'totalfavorites' => Auth::user()->profile->favorites()
                        ->where('is_active', true)->count(),
                ]
            );
        }

        return redirect()->back();
    }
}
