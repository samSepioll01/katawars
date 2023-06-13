<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKatawayRequest;
use App\Http\Requests\UpdateKatawayRequest;
use App\Models\Kataway;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KatawayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kataways = Kataway::orderBy('id');

        if ($request->search) {
            $kataways = Kataway::search($request->search);
        }

        return view('kataways.index', [
            'kataways' => $kataways->get(),
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
     * @param  \App\Http\Requests\StoreKatawayRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKatawayRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kataway  $kataway
     * @return \Illuminate\Http\Response
     */
    public function show(Kataway $kataway)
    {
        $profile = Auth::user()->profile;
        $completedKatas = 0;

        $isSubscribe = $profile->startedKataways
            ->where('id', $kataway->id)
            ->first();

        $isCompleted = $profile->completedKataways()->contains($kataway);

        if ($isCompleted) {
            $completedKatas = $kataway->katas;
        } else {

            $passedKatas = $profile->passedKatas;
            $katawayKatas = $kataway->katas;
            $completedKatas = $katawayKatas
                ->filter(fn($kata) => $passedKatas->contains($kata));
        }

        return view('kataways.show', [
            'kataway' => $kataway,
            'isSubscribe' => $isSubscribe,
            'completedKatas' => $completedKatas,
            'isCompleted' => $isCompleted,
        ]);
    }

    /**
     * Set the kataway was completed.
     * @param \App\Models\Kataway $kataway
     * @return \Illuminate\Http\Response
     */
    public function completeKataway(Kataway $kataway)
    {
        $profile = Auth::user()->profile;

        $completed = $profile->startedKataways
            ->where('id', $kataway->id)
            ->first()
            ->pivot;

        $completed->end_date = now();
        $completed->save();

        $points = Score::where('denomination', 'complete kataway')
            ->first()->points;

        $profile->exp = $points;
        $profile->save();

        $kataway->createScoreRecord();

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', "Congrats!! Kataway Completed!! You have won $points EXP!!");

        return redirect()->back();
    }

    /**
     * Set where the user start a kataway.
     */
    public function subscribeKataway(Kataway $kataway)
    {
        Auth::user()->profile->startedKataways()->attach($kataway);

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'Subscribe successful to ' . $kataway->title . ' kataway. Enjoy!');

        return redirect()->back();
    }

    /**
     * Set when the user end a kataways without end it.
     */
    public function unsubscribeKataway(Kataway $kataway)
    {
        Auth::user()->profile->startedKataways()->detach($kataway);

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'Unsubscribed successful for the kataway. Come back soon!');

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kataway  $kataway
     * @return \Illuminate\Http\Response
     */
    public function edit(Kataway $kataway)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKatawayRequest  $request
     * @param  \App\Models\Kataway  $kataway
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKatawayRequest $request, Kataway $kataway)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kataway  $kataway
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kataway $kataway)
    {
        //
    }
}
