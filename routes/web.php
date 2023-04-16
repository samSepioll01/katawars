<?php

use App\Http\Controllers\appThemeController;
use App\Http\Controllers\Auth\GitHubLoginController;
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

Route::get('/', [appThemeController::class, 'initialConfig'])->name('home');
Route::get('/privacy-policy', fn() => view('policy'))->name('privacy-policy');
Route::get('/terms-of-service', fn() => view('terms'))->name('terms-service');

// Layout Change Theme

Route::post('/save-theme', [appThemeController::class, 'saveModifiedTheme'])
    ->name('save-theme');

// GitHub Login

Route::get('/login/github', [GitHubLoginController::class, 'redirectToProvider']);
Route::get('/login/github/callback/{sync?}', [GitHubLoginController::class, 'handleProviderCallback']);

// Auth User

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/user/dashboard', [appThemeController::class, 'authUserThemeConfig'])
        ->name('dashboard');

    Route::get('/user', function() {
        return redirect()->route('dashboard');
    });
});
