<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GitHubLoginController;
use App\Http\Controllers\HelpController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Guest

Route::get('/', [ProfileController::class, 'initialConfig'])->name('home');
Route::get('/privacy-policy', fn() => view('policy'))->name('privacy-policy');
Route::get('/terms-of-service', fn() => view('terms'))->name('terms-service');
Route::get('/help', [HelpController::class, 'index'])->name('help');

Route::fallback(function() {
    return view('errors.404');
});

// Layout Change Theme

Route::post('/save-theme', [ProfileController::class, 'saveModifiedTheme'])
    ->name('save-theme');

// GitHub Login

Route::get('/login/github', [GitHubLoginController::class, 'redirectToProvider'])
    ->name('github.login');
Route::get('/login/github/callback', [GitHubLoginController::class, 'handleProviderCallback']);

// Auth User

Route::prefix('user')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::get('/dashboard', [ProfileController::class, 'authUserThemeConfig'])
        ->name('dashboard');

    Route::get('/', function() {
        return redirect()->route('dashboard');
    });

    // GitHub User Account Sync
    Route::get('/profile/sync/github', [GitHubLoginController::class, 'redirectToProvider'])
        ->name('github.sync');
});

Route::prefix('users')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::get('/{slug}', [ProfileController::class, 'showProfilesMainPage'])
        ->name('users.main');
});
