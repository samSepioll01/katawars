<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKataRequest;
use App\Http\Requests\UpdateKataRequest;
use App\Models\Kata;
use App\Models\Rank;
use Illuminate\Http\Request;
use Illuminate\Pagination\Cursor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class KataController extends Controller
{
    private const PER_PAGE = 10;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'ord' => ['nullable', 'string', 'max:10'],
            'category' => ['nullable', 'string', 'max:50'],
            'selected' => ['nullable', 'string', 'max:50'],
            'nextCursor' => ['nullable', 'string', 'max:255'],
        ]);

        $nextCursor = $request->query('nextCursor')
            ? Cursor::fromEncoded($request->query('nextCursor'))
            : null;

        $mykatas = Auth::user()->profile->ownerKatas()
            ->orderBy(
                'id',
                $request->query('ord') ?? 'asc',
            );

        if ($request->query('selected') === 'true') {
            $mykatas = $mykatas->when($request->query('category') ?? false, fn($query) =>
                $query->whereHas('challenge', fn($query) =>
                    $query->whereHas('categories', fn($query) =>
                        $query->where('name', $request->query('category'))
                    )
                )
            );
        }

        $mykatas = $mykatas->cursorPaginate(
            self::PER_PAGE, ['*'], 'cursor', $nextCursor
        );

        if ($mykatas->hasMorePages()) {
            $nextCursor = $mykatas->nextCursor()->encode();
        }

        if ($request->ajax()) {

            if (Auth::user()->profile->ownerKatas->count() > self::PER_PAGE) {
                $returnHTML = view('includes.mykatas', [
                    'mykatas' => $mykatas,
                    'nextCursor' => $nextCursor,
                ])->render();
            } else {
                $returnHTML = '';
            }

            return response()->json([
                'success' => true,
                'html' => $returnHTML,
                'nextCursor' => $nextCursor ?? '',
            ]);
        }



        $lastUpdated = Auth::user()->profile->ownerKatas()
            ->orderBy('created_at', 'asc')
            ?->first()
            ?->created_at;

        if ($lastUpdated) {
            $lastUpdated = $lastUpdated->diffForHumans(now());
            if ($lastUpdated === '1 day before') $lastUpdated = 'yesterday';

            if (Str::of($lastUpdated)->contains(['hour','minute', 'second'])) {
                $lastUpdated = 'today';
            }
        }

        $isAllowed = auth()->user()->hasRole(['admin', 'superadmin'])
            || auth()->user()->profile->rank_id === Rank::where('name', 'black')->first()->id;

        return view('mykatas.index', [
            'mykatas' => $mykatas,
            'totalKatas' => Auth::user()->profile->ownerKatas->count(),
            'lastUpdated' => $lastUpdated,
            'nextCursor' => $nextCursor,
            'isAllowed' => $isAllowed,
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
     * @param  \App\Http\Requests\StoreKataRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKataRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kata  $kata
     * @return \Illuminate\Http\Response
     */
    public function show(Kata $kata)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kata  $kata
     * @return \Illuminate\Http\Response
     */
    public function edit(Kata $kata)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKataRequest  $request
     * @param  \App\Models\Kata  $kata
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKataRequest $request, Kata $kata)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kata  $kata
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kata $kata)
    {
        //
    }
}
