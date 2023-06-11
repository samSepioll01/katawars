<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHelpRequest;
use App\Http\Requests\UpdateHelpRequest;
use App\Models\Help;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('help', [
            'sections' => Help::distinct()->pluck('section'),
            'helps' => Help::all(),
            'updatedAt' => Help::orderBy('updated_at')->first()->updated_at,
        ])->render();
    }

    public function showHelps(Request $request)
    {
        $helps = Help::orderBy('id');

        if ($request->search) {
            $helps = Help::search($request->search);
        }

        return view('admin.helps.index', [
            'helps' => $helps->paginate(10)->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.helps.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreHelpRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHelpRequest $request)
    {
        Help::create([
            'title' => $request->title,
            'description' => $request->description,
            'section' => $request->section,
        ]);

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'Help created successful!');

        return redirect()->route('admin.helps.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Help  $help
     * @return \Illuminate\Http\Response
     */
    public function show(Help $help)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Help  $help
     * @return \Illuminate\Http\Response
     */
    public function edit(Help $help)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHelpRequest  $request
     * @param  \App\Models\Help  $help
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHelpRequest $request, Help $help)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Help  $help
     * @return \Illuminate\Http\Response
     */
    public function destroy(Help $help)
    {
        //
    }
}
