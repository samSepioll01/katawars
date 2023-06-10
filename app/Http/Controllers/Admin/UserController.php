<?php

namespace App\Http\Controllers\Admin;

use App\CustomClasses\CircularCollection;
use App\CustomClasses\S3;
use App\Http\Controllers\Controller;
use App\Jobs\BannedJob;
use App\Jobs\RecoveryBannedJob;
use App\Models\Challenge;
use App\Models\Kata;
use App\Models\Profile;
use App\Models\Rank;
use App\Models\Session as ModelsSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

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
        $user = User::withTrashed()->find($id);

        return view('admin.users.show', [
            'user' => $user,
            'previous' => $circular->previous($user),
            'next' => $circular->next($user),
        ]);
    }

    /**
     * Show all the users that are banned for the admin.
     * @return \Illuminate\Http\Response
     */
    public function showBanned()
    {
        return view('admin.users.index', [
            'users' => User::onlyTrashed()->paginate(10),
        ]);
    }

    /**
     * Show all the challenges created by the user.
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function showCreatedChallenges(User $user)
    {
        return view('admin.challenges.index', [
            'user' => $user,
            'katas' => $user->profile->ownerKatas()->paginate(20),
        ]);
    }

    /**
     * Show specific created challenge by the user.
     *
     * @param \App\Models\User $user
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function showCreatedChallenge(User $user, $id)
    {
        $challenge = Challenge::findOrFail($id);

        return view('admin.challenges.show', [
            'user' => $user,
            'challenge' => $challenge,
            'test_code' => Storage::disk('s3')->get($challenge->katas->first()->uri_test),
        ]);
    }

    /**
     * Show the previous|next user throught id of the showed actually user.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
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
        $user = User::find($id);
        $profilePhotos = S3::getProfilePhotos($user, false);

        $profilePhotos = collect($profilePhotos)
            ->map(fn($photoPath) => env('AWS_PROFILE_URL') . '/' .$photoPath);

        return view('admin.users.edit', [
            'user' => $user,
            'profilePhotos' => $profilePhotos,
        ]);
    }

    /**
     * Admin ability for delete user profile photo.
     *
     * @param \App\Models\User $user
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function deletePhoto(User $user, Request $request)
    {
        $request->validate([
            'index' => ['integer'],
        ]);

        $photos = S3::getProfilePhotos($user);

        if ($request->index < 0 || $request->index > count($photos) - 1) {
            abort(404);
        }

        $current = S3::filterPath($photos[$request->index]);

        Storage::disk('s3')->delete($current);

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'Profile Photo deleted successful!');

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param User $user
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Request $request)
    {
        if ($request->name !== $user->name) {
            Profile::validateUrlProfile($request->name);
        }

        $request->validate([
            'rank' => ['required', 'string'],
            'role' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'honor' => ['required', 'integer'],
        ]);


        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;
        $user->save();

        if ($request->email !== $user->email) {
            $user->sendEmailVerificationNotification();
        }

        $user->syncRoles([Role::findByName($request->role, 'web')->name]);

        $profile = $user->profile;
        $rank = Rank::where('name', $request->rank)->first();

        $slug = Str::slug($request->name);
        $profile->slug = $slug;
        $profile->url = url("/user/$slug");
        $profile->rank_id = $rank->id;
        $profile->honor = $request->honor;
        $profile->save();

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'User Info updated successful!');

        return redirect()->back();
    }


    /**
     * Set the ban for the user
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function toBan(User $user)
    {


        if (User::isOnline($user)) {

            DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('user_id', $user->getAuthIdentifier())
            ->where('id', '!=', request()->session()->getId())
            ->delete();
        }

        $profile = $user->profile;
        $profile->is_banned = true;
        $profile->save();

        $user->delete();

        BannedJob::dispatch($user)->onQueue('sendMailQueue');

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'User banned successful!');

        return redirect()->route('users.index');
    }

    /**
     * Recovery the user for the ban.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function recoveryBanned(int $id)
    {
        $user = User::withTrashed()->find($id);
        $profile = $user->profile;
        $profile->is_banned = false;
        $profile->save();
        $user->restore();
        RecoveryBannedJob::dispatch($user)->onQueue('sendMailQueue');
        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'User restored successful!');

        return redirect()->route('users.index');
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
