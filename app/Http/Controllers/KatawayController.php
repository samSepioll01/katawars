<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKatawayRequest;
use App\Http\Requests\UpdateKatawayRequest;
use App\Models\Challenge;
use App\Models\Kata;
use App\Models\Kataway;
use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

    public function showAllKataways(Request $request)
    {
        $kataways = Kataway::orderBy('id');

        if ($request->search) {
            $kataways = Kataway::search($request->search);
        }

        return view('admin.kataways.kataways', [
            'kataways' => $kataways->paginate(10)->withQueryString(),
        ]);
    }

    public function showKataway(Kataway $kataway)
    {
        return view('admin.kataways.show', [
            'kataway' => $kataway,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $challenges = Challenge::whereHas(
            'katas',
            fn($query) => $query->where('mode_id', 1),
        )->get();

        return view('kataways.create', [
            'challenges' => $challenges,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKatawayRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKatawayRequest $request)
    {

        if (count($request->input('katas')) < 2) {
            session()->flash('syncStatus', 'error');
            session()->flash('syncMessage', 'The challenges selected must be greather than 1.');
            return redirect()->back();
        }

        $existsKatas = collect($request->input('katas'))
            ->every(fn($kataID) => Kata::where('id', $kataID)->exists());

        if (!$existsKatas) {
            session()->flash('syncStatus', 'error');
            session()->flash('syncMessage', 'Not exists some katas selected.');
            return redirect()->back();
        }

        $slug = Str::slug($request->title);

        $kataway = Kataway::create([
            'owner_id' => Auth::user()->profile->id,
            'title' => $request->title,
            'description' => $request->description,
            'slug' => $slug,
            'url' => url("/kataways/$slug"),
        ]);

        $kataway->katas()->sync($request->input('katas'));

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'Kataway created successful!!');
        return redirect()->route('kataways.index');
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
        if ($kataway->createdByProfile->id !== Auth::user()->profile->id) {
            abort(403);
        }

        return view('kataways.edit', [
            'kataway' => $kataway,
        ]);
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
        if (Auth::user()->profile->id !== $kataway->createdByProfile->id) {
            abort(403);
        }

        $kataway->title = $request->title;
        $kataway->description = $request->description;
        $kataway->save();

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'Kataway updated successful!!');

        return redirect()->route('kataways.show', $kataway);

    }

    public function destroyMultipleKataways(User $user, Request $request)
    {
        $ids = $request->input('ids');
        Kataway::destroy($ids);

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'Kataways deleted successful!');

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroyUserKataway(User $user, $id)
    {
        $kataway = Kataway::where('id', $id)->first();

        $kataway->delete();

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'Kataway deleted successful!!');

        return redirect()->route('users.kataways', [
            'user' => $user,
        ]);
    }

    public function destroy(Kataway $kataway, Request $request)
    {
        $kataway->delete();


        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'Comment deleted sucessful!');

        return redirect()->route('admin.kataways.index');
    }
}
