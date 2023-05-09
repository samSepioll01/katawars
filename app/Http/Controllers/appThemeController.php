<?php

namespace App\Http\Controllers;

use App\Events\ThemeModeUpdated;
use App\Models\User;
use Carbon\Carbon;

class appThemeController extends Controller
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

    /**
     * Set the config theme for the user session or for a named theme passed.
     */
    private function setSessionTheme($theme = null)
    {
        session($this->modesValues[$theme ?? session('theme')]);
    }

    private function getUserDashboardValues(User $user)
    {
        $lastSession = $user->sessions->sortByDesc('last_activity')
                            ->first()->last_activity;

        return [
            'nickname' => $user->name,
            'bio' => $user->bio,
            'rank' => $user->profile->rank->name,
            'time_elapsed' => $user->created_at->diffForHumans(now()),
            'last_activity' => (new Carbon($lastSession)),
            'exp' => $user->profile->exp,
            'honor' => $user->profile->honor,
            'exp2next' => $user->profile->exp / $user->profile->rank->level_up * 100,
            'count_followers' => $user->profile->followers()->count(),
            'count_following' => $user->profile->following()->count(),
        ];
    }
}
