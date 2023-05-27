<?php

namespace App\Http\Controllers;

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

        $favoritesKatas = Auth::user()->profile->favorites();

        if ($request->ajax()) {

            $favoritesKatas = $favoritesKatas->orderBy(
                'id',
                $request->query('sort'),
            )->get();

            $returnHTML = view('includes.favorites', [
                'favoritesKatas' => $favoritesKatas
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
            'favoritesKatas' => $favoritesKatas,
            'lastUpdated' => $lastUpdated,
            'totalFavorites' => Auth::user()->profile->favorites()->count(),
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
    public function destroy($id)
    {
        //
    }
}
