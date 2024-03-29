<?php

namespace App\Http\Controllers\Admin;

use App\CustomClasses\CircularCollection;
use App\CustomClasses\S3;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Jobs\BannedJob;
use App\Jobs\CreateAccountPassJob;
use App\Jobs\RecoveryBannedJob;
use App\Mail\GitHubLoginPasswordMail;
use App\Models\Challenge;
use App\Models\Comment;
use App\Models\Kata;
use App\Models\Kataway;
use App\Models\Profile;
use App\Models\Rank;
use App\Models\Session as ModelsSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
    public function index(Request $request)
    {
        $users = User::orderBy('id');

        if ($request->search) {
            $users = User::search($request->search);
        }

        return view('admin.users.index', [
            'users' => $users->paginate(10)->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        Profile::validateUrlProfile($request->name);

        $exp = $request->exp ?: Rank::where('name', $request->rank)->first()->level_up;

        $password = substr(
            Hash::make(
                $request->name
                . $request->email
                . now()
            ),
            7, 16,
        );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'bio' => $request->bio ?? '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        CreateAccountPassJob::dispatch($user->name, $user->email, $password)->onQueue('sendMailQueue');

        $user->assignRole(Role::findByName($request->role, 'web')->name);

        $slug = Str::slug($request->name);

        Profile::create([
            'slug' => $slug,
            'url' => url("/users/$slug"),
            'exp' => $exp,
            'honor' => $request->honor ?: 0,
            'is_darkmode' => true,
            'is_deleted' => false,
            'is_banned' => false,
            'rank_id' => Rank::where('name', $request->rank)->first()->id,
            'last_activity' => (int) now()->valueOf(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'User created successful!');

        return redirect()->route('users.index');
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
    public function showCreatedChallenges(User $user, Request $request)
    {
        $challenges = $user->profile->ownerKatas();

        if ($request->search) {
            $challenges = $challenges->get();
            $search = Challenge::search($request->search)->get();
            $challenges = $challenges->intersect($search);

            $page = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 10;
            $results = $challenges->slice(($page - 1) * $perPage, $perPage)->all();
            $paginated = new LengthAwarePaginator($results, count($challenges), $perPage);
        } else {
            $paginated = $challenges->paginate(20);
        }

        return view('admin.challenges.index', [
            'user' => $user,
            'katas' => $paginated,
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
        $challenge = Challenge::find($id);

        return view('admin.challenges.show', [
            'user' => $user,
            'challenge' => $challenge,
            'test_code' => Storage::disk('s3')->get($challenge->katas->first()->uri_test),
        ]);
    }

    public function showCreatedKataways(User $user, Request $request)
    {

        $kataways = Kataway::where('owner_id', $user->id);

        if ($request->search) {
            $kataways = Kataway::search($request->search);
        }

        return view('admin.kataways.index', [
            'user' => $user,
            'kataways' => $kataways->paginate(5),
        ]);
    }

    public function showCreatedKataway(User $user, $id)
    {
        $kataway = Kataway::find($id);

        return view('admin.kataways.user-show', [
            'user' => $user,
            'kataway' => $kataway,
        ]);
    }

    public function showComments(User $user)
    {
        return view('admin.users.comments.index', [
            'user' => $user,
            'comments' => $user->profile->comments()->paginate(10),
        ]);
    }

    public function showComment(User $user, Request $request)
    {

        $comment = Comment::find($request->comment);

        return view('admin.users.comments.show', [
            'user' => $user,
            'comment' => $comment,
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
        $user = User::withTrashed()->find($id);
        $user->forceDelete();

        session()->flash('syncStatus', 'success');
        session()->flash('syncMessage', 'User deleted succesful!');

        return redirect()->route('users.index');
    }
}
