<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Pagination\Cursor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SavedKatasController extends Controller
{
    private const PER_PAGE = 5;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'nextCursor' => ['string', 'max:255', 'nullable'],
        ]);

        $nextCursor = $request->query('nextCursor')
            ? Cursor::fromEncoded($request->query('nextCursor'))
            : null;

        $savedKatas = Profile::getSavedKatas()
            ->cursorPaginate(self::PER_PAGE, ['*'], 'cursor', $nextCursor);

        if ($savedKatas->hasMorePages()) {
            $nextCursor = $savedKatas->nextCursor()->encode();
        }

        if ($request->ajax()) {
            $returnHTML = view('includes.saved', [
                'savedKatas' => $savedKatas
            ])->render();

            return response()->json([
                'success' => true,
                'html' => $returnHTML,
                'nextCursor' => $nextCursor ?? '',
            ]);
        }

        $lastUpdated = Auth::user()->profile->savedKatas()
            ->orderByPivot('updated_at', 'desc')
            ->first()
            ?->pivot->updated_at;

        if ($lastUpdated) {
            $lastUpdated = $lastUpdated->diffForHumans(now());
            if ($lastUpdated === '1 day before') $lastUpdated = 'yesterday';

            if (Str::of($lastUpdated)->contains(['hour','minute', 'second'])) {
                $lastUpdated = 'today';
            }
        }

        return view('katas.saved', [
            'savedKatas' => $savedKatas,
            'nextCursor' => $nextCursor,
            'lastUpdated' => $lastUpdated,
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
