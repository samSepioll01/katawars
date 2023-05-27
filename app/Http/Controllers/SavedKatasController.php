<?php

namespace App\Http\Controllers;

use App\Models\Kata;
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
            'totalSavedKatas' => auth()->user()->profile->savedKatas()->count(),
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

        $kata = Kata::where('id', $request->id)->firstOrFail();
        $savedKatas = Auth::user()->profile->savedKatas();

        if ($savedKatas->get()->contains($kata->id)) {

            $savedKatas->detach($kata->id);
        } else {

            if ($savedKatas->count()) {
                $num_orden = $savedKatas->orderByPivot('num_orden', 'desc')
                    ->first()->pivot->num_orden + 1;
            } else {
                $num_orden = 1;
            }

            $savedKatas->attach($kata->id, [
                'num_orden' => $num_orden,
            ]);
        }

        return response()->json(['success' => true]);
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'target' => ['integer', 'required'],
            'modifiedOrder' => ['array', 'required'],
        ]);

        if ($request->ajax()) {

            $originalOrder = Profile::getSavedKatas()->get()
                                ->map(fn($elem) => $elem->id);

            $originalPos = $originalOrder->search($request->target) + 1;
            $destinationPos = collect($request->modifiedOrder)
                                ->search($request->target) + 1;

            if ($originalPos === $destinationPos) {
                return response()->json(['success' => true]);
            }

            $target = Profile::getSavedKatas($request->target)->pivot;
            $target->num_orden = $destinationPos;
            $target->save();

            if ($originalPos < $destinationPos) {
                $elems2Mod = Profile::getSavedKatas()->get()
                    ->filter(fn($elem) =>
                        $elem->pivot->num_orden > $originalPos
                        &&
                        $elem->pivot->num_orden <= $destinationPos
                    )
                    ->except($request->target);

                $elems2Mod->each(function($elem) {
                    $elem = $elem->pivot;
                    $elem->num_orden -= 1;
                    $elem->save();
                });
            }

            if ($originalPos > $destinationPos) {
                $elems2Mod = Profile::getSavedKatas()->get()
                    ->filter(fn($elem) =>
                        $elem->pivot->num_orden >= $destinationPos
                        &&
                        $elem->pivot->num_orden < $originalPos
                    )
                    ->except($request->target);

                $elems2Mod->each(function($elem) {
                    $elem = $elem->pivot;
                    $elem->num_orden += 1;
                    $elem->save();
                });

            }
        }

        return response()->json(['success' => true]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (request()->ajax()) {

            $savedKatas = Profile::getSavedKatas()->get();
            $savedKata = $savedKatas->find($id);
            $savedKata ?? abort(404);
            $numOrden = $savedKata->pivot->num_orden;
            $nextSavedKata = $savedKatas->filter(fn($savedKata) =>
                    $savedKata->pivot->num_orden === $numOrden + self::PER_PAGE
            );

            $returnHTML = view('includes.saved', [
                'savedKatas' => $nextSavedKata,
            ])->render();

            $savedKatas->slice($numOrden)->each(function($elem) {
                $pivot = $elem->pivot;
                $pivot->num_orden -= 1;
                $pivot->save();
            });

            Profile::getsavedKatas()->detach($id);

            $totalSavedKatas = auth()->user()->profile->savedKatas()->count();

            if (!$totalSavedKatas) $returnHTML = '<h1 class="flex items-center text-lg dark:text-slate-100 font-semibold justify-center">Your list its empty.</h1>';

            return response()->json(
                [
                    'success' => true,
                    'html' => $returnHTML,
                    'totalSavedKatas' => $totalSavedKatas,
                ]
            );
        }

        return redirect()->back();
    }
}
