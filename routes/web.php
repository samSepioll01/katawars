<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GitHubLoginController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\SavedKatasController;
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

    Route::get('/{slug}', [ProfileController::class, 'showProfilesMainPage'])
    ->name('users.main');
});


// Admin Section
Route::prefix('admin')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:superadmin|admin',
])->group(function () {

    Route::get('/', function() {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', function() {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::get('/training', [ChallengeController::class, 'showChallenges'])
        ->name('challenges.training');

    Route::get('/dojo', [ProfileController::class, 'showDojo'])
        ->name('dojo.index');

    Route::get('/saved-katas', [SavedKatasController::class, 'index'])
        ->name('katas.saved');

    // Add Saved Kata to the list
    Route::post('/saved-katas/{id}', [SavedKatasController::class, 'store'])
        ->name('katas.store');

    // Manually Sort
    Route::patch('/saved-katas/update', [SavedKatasController::class, 'update'])
        ->name('katas.update');

    Route::delete('/saved-katas/{id}', [SavedKatasController::class, 'destroy'])
        ->name('katas.destroy');

    Route::get('/katas/next', [ChallengeController::class, 'showNextChallenge'])
        ->name('katas.next');

    Route::get('/katas/{slug}', [ChallengeController::class, 'showKataMainPage'])
        ->name('katas.main-page');

    Route::post('/katas/{slug}/verify-kata', [ChallengeController::class, 'verifyKata'])
        ->name('katas.verify');

    Route::get('/favorites', [FavoritesController::class, 'index'])
        ->name('katas.favorites');

    Route::put('favorites/{id}', [FavoritesController::class, 'store'])
        ->name('favorites.store');
});
