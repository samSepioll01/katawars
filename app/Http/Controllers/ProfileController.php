<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use App\Events\ThemeModeUpdated;
use App\Jobs\ReportNewFollower;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    public function showDojo(Request $request)
    {
        $this->validateRequest($request->query());

        $users = User::whereHas('roles', fn($query) => $query->where('name', 'user'))
                    ->get()->except(Auth::user()->id);


        if ($request->ajax()) {

                $search = User::search($request->query('search'))->get();
                $searchUsers = $users->intersect($search);

                if ($searchUsers->count()) {

                    $returnHTML = view('includes.dojoprofiles', [
                        'users' => $searchUsers,
                    ])->render();
                } else {
                    $returnHTML = '<h1 class="flex items-center text-lg dark:text-slate-100 font-semibold justify-center">Sorry. No results for your search.</h1>';
                }

                return response()->json([
                    'success' => true,
                    'users' => $returnHTML,
                ]);
        }

        return view('dojo.index', [
            'users' => $users,
        ]);
    }

    /**
     * Check if the incomming request validate his parameters.
     */
    protected function validateRequest($queryBag)
    {
        $validator = Validator::make($queryBag, [
            'search' => ['nullable', 'string', 'max:255', 'alpha_num'],
            'searcher' => ['string', 'max:4', 'alpha_num'],
        ]);

        if ($validator->fails()) {
            abort(404);
        }
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

        if (Auth::check()) {

            if (Auth::user()->hasRole(['superadmin', 'admin'])) {
                return redirect()->route('admin.dashboard');
            }

            if (Auth::user()->hasRole(['user'])) {
                return redirect()->route('dashboard');
            }

        } else {
            return view('welcome')->render();
        }
    }

    /**
     * Configure the app layout for the auth user.
     */
    public function authUserThemeConfig()
    {
        $user = Auth::user();

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

            if (Auth::check()) {
                $profile = Auth::user()->profile;
                $profile->is_darkmode = request()->theme === 'dark' ? true : false;
                $profile->save();
            }

            $this->setSessionTheme(request()->theme);

            event( (new ThemeModeUpdated(Auth::user()))
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

        $request->validate([
            'slug' => ['string', 'unique:profile', 'max:255'],
        ]);

        $profile = Profile::where('slug', $request->slug)->firstOrFail();

        return view('profile.dashboard', [
            'userValues' => $this->getUserDashboardValues($profile->user),
        ]);
    }

    public function getFollowers(Request $request)
    {
        $request->validate([
            'slug' => ['string', 'max:255', 'alpha_num']
        ]);

        if ($request->ajax()) {

            $profile = Profile::where('slug', $request->slug)->firstOrFail();

            $returnHTML = view('includes.follow', [
                'follows' => $profile->followers()->get(),
            ])->render();

            return response()->json([
                'success' => true,
                'returnHTML' => $returnHTML,
            ]);
        }
    }

    public function getFollowees(Request $request)
    {
        $request->validate([
            'slug' => ['string', 'max:255', 'alpha_num']
        ]);

        if ($request->ajax()) {

            $profile = Profile::where('slug', $request->slug)->firstOrFail();

            $returnHTML = view('includes.follow', [
                'follows' => $profile->following()->get(),
            ])->render();

            return response()->json([
                'success' => true,
                'returnHTML' => $returnHTML,
            ]);
        }

    }

    public function changeFollow(Request $request)
    {
        $request->validate([
            'slug' => ['string', 'max:255', 'alpha_num']
        ]);

        if ($request->ajax()) {

            $userProfile = Auth::user()->profile;
            $profileTarget = Profile::where('slug', $request->slug)->firstOrFail();

            if ($userProfile->id !== $profileTarget->id) {

                $userProfile->following()->toggle($profileTarget);

                if ($userProfile->isFollowing($profileTarget) ) {

                    ReportNewFollower::dispatch($userProfile, $profileTarget)
                        ->onQueue('sendMailQueue');
                }

                $url = request()->session()->get('_previous.url');
                $slug = $this->getUrlSlug($url);

                if ($slug === $userProfile->slug || $slug === 'dashboard') {

                    $followers = $userProfile->followers()->count();
                    $following = $userProfile->following()->count();

                } else {

                    $profileMainPage = Profile::where('slug', $slug)->firstOrFail();
                    $followers = $profileMainPage->followers()->count();
                    $following = $profileMainPage->following()->count();
                }

                $refreshBTN = view('includes.follow-btn', [
                    'profile' => $profileTarget,
                ])->render();

                return response()->json([
                    'success' => true,
                    'refreshbutton' => $refreshBTN,
                    'followers' => $followers,
                    'following' => $following,
                ]);

            }
        }
    }

    /**
     * Get the slug of a url.
     *
     * @param string $url
     * @return string
     */
    protected function getUrlSlug(string $url): string
    {
        $routes = explode('/', $url);
        return $routes[count($routes) - 1];
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
        return [
            'id' => $user->id,
            'nickname' => $user->name,
            'bio' => $user->bio,
            'slug' => $user->profile->slug,
            'avatar' => $user->profile_photo_url,
            'rank' => $user->profile->rank->name,
            'time_elapsed' => $user->created_at->diffForHumans(now()),
            'last_activity' => $user->last_activity(),
            'exp' => $user->profile->exp,
            'honor' => $user->profile->honor,
            'count_followers' => $user->profile->followers()->count(),
            'count_following' => $user->profile->following()->count(),
            'ranking' => $user->ranking(),
            'progress' => $user->profile->getProfileProgress(),
            'followers' => $user->profile->followers,
            'followees' => $user->profile->following,
        ];
    }
}
