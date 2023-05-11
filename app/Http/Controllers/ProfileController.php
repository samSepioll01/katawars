<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use App\Events\ThemeModeUpdated;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * @var Array Contain the information about modes configurations.
     */
    private $modesValues;

    public function __construct()
    {
        $this->modesValues = [
            'dark' => [
                'theme' => 'dark',
                'urlModeIcon' => env('AWS_APP_URL') . '/icons/brillo.png',
                'scrollbar' => 'scrollbar-dark',
            ],
            'light' => [
                'theme' => 'light',
                'urlModeIcon' => env('AWS_APP_URL') . '/icons/modo-nocturno.png',
                'scrollbar' => 'scrollbar-light',
            ],
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreProfileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProfileRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProfileRequest  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }

    /**
     * Sets users initial interface theme configuration.
     */
    public function initialConfig()
    {
        // Difference between first time git in app vs get in previously.
        $this->setSessionTheme(
            session()->missing('theme') ? 'dark' : null
        );

        return auth()->check()
            ? redirect()->route('dashboard')
            : view('welcome')->render();
    }

    /**
     * Configure the app layout for the auth user.
     */
    public function authUserThemeConfig()
    {
        $user = auth()->user();

        // Hold the theme selected by the guest user for 1 minute.
        // After, hold the theme selected by the auth user.
        if ($user->created_at->diffInMinutes() < 1) {
            $profile = $user->profile;
            $profile->is_darkmode = session('theme') === 'dark' ? true : false;
            $profile->save();
        }

        return view('profile.dashboard', [
            'userValues' => $this->getUserDashboardValues($user),
        ]);
    }

    /**
     * Handles operations to persist data from manual interface theme change.
     */
    public function saveModifiedTheme()
    {
        if (request()->ajax()) {

            if (auth()->check()) {
                $profile = auth()->user()->profile;
                $profile->is_darkmode = request()->theme === 'dark' ? true : false;
                $profile->save();
            }

            $this->setSessionTheme(request()->theme);

            event( (new ThemeModeUpdated(auth()->user()))
                ->dontBroadcastToCurrentUser()
            );

            return response()->json(
                [
                    'success' => true,
                    'theme' => request()->theme,
                ]
            );
        }
    }

    public function showProfilesMainPage(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'slug' => ['string', 'unique:profile', 'max:255'],
        ]);

        if ($validator->fails()) {
            abort(404);
        }


        $profile = Profile::where('slug', $request->slug)->firstOrFail();

        return view('profile.dashboard', [
            'userValues' => $this->getUserDashboardValues($profile->user),
        ]);


    }

    /**
     * Set the config theme for the user session or for a named theme passed.
     */
    private function setSessionTheme($theme = null)
    {
        session($this->modesValues[$theme ?? session('theme')]);
    }

    /**
     * Get all the values necessary for the main page of the user.
     *
     * @param App\Models\User $user
     * @return array
     */
    private function getUserDashboardValues(User $user): array
    {
        $last_activity = User::isOnline($user)
            ? 'Online'
            : (new Carbon($user->profile->last_activity));

        $ranking = Profile::orderByDesc('exp')->get()
            ->search(Auth::user()->profile) + 1;

        return [
            'id' => $user->id,
            'nickname' => $user->name,
            'bio' => $user->bio,
            'avatar' => $user->profile_photo_url,
            'rank' => $user->profile->rank->name,
            'time_elapsed' => $user->created_at->diffForHumans(now()),
            'last_activity' => $last_activity,
            'exp' => $user->profile->exp,
            'honor' => $user->profile->honor,
            'exp2next' => $user->profile->exp / $user->profile->rank->level_up * 100,
            'count_followers' => $user->profile->followers()->count(),
            'count_following' => $user->profile->following()->count(),
            'ranking' => $ranking,
        ];
    }
}
