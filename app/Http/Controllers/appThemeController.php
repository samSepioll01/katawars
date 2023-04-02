<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
                'urlModeIcon' => url('/storage/icons/brillo.png'),
                'scrollbar' => 'scrollbar-dark',
            ],
            'light' => [
                'theme' => 'light',
                'urlModeIcon' => url('/storage/icons/modo-nocturno.png'),
                'scrollbar' => 'scrollbar-light',
            ],
        ];
    }

    /**
     * Sets users initial interface theme configuration.
     */
    public function initialConfig()
    {
        return view('welcome')->render();
    }

    /**
     * Configure the app layout for the auth user.
     */
    public function authUserThemeConfig()
    {
        return view('profile.dashboard')->render();
    }

    /**
     * Handles operations to persist the data from manual interface theme changes.
     */
    public function saveModifiedTheme()
    {
        return true;
    }

    /**
     * Set the config for the user session or for a named theme passed.
     */
    private function setSessionTheme(string|null $theme = null)
    {
        session($this->modesValues[$theme ?? session('theme')]);
    }
}
