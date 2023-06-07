<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GitHubLoginController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\KataController;
use App\Http\Controllers\MessengerController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SavedKatasController;
use App\Http\Controllers\SolutionController;
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

    Route::post('/{slug}/change-follow', [ProfileController::class, 'changeFollow'])
        ->name('user.change-follow');

    Route::get('/{slug}/followers', [ProfileController::class, 'getFollowers'])
        ->name('user.followers');

    Route::get('/{slug}/following', [ProfileController::class, 'getFollowees'])
        ->name('user.following');
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

    Route::get('/my-katas', [KataController::class, 'index'])
        ->name('mykatas.index');

    Route::get('/my-katas/create', [KataController::class, 'create'])
        ->name('mykatas.create');

    Route::delete('/my-katas/{kata}', [KataController::class, 'destroy'])
        ->name('mykatas.destroy');

    Route::get('/my-katas/{kata}/edit', [KataController::class, 'edit'])
        ->name('mykatas.edit');

    Route::put('/my-katas/{kata}', [KataController::class, 'update'])
        ->name('mykatas.update');

    Route::post('my-katas/store', [KataController::class, 'store'])
        ->name('mykatas.store');

    Route::post('/katas/{challenge:slug}/comments', [CommentController::class, 'store'])
        ->name('katas.comment.store');

    Route::delete('/katas/{challenge:slug}/comments/{comment:id}', [CommentController::class, 'destroy'])
        ->name('katas.comment.destroy');

    Route::get('/katas/{challenge:slug}/comments/{comment:id}/edit', [CommentController::class, 'edit'])
        ->name('katas.comment.edit');

    Route::patch('/katas/{challenge:slug}/comments/{comment:id}', [CommentController::class, 'update'])
        ->name('katas.comment.update');

    Route::get('/messenger', [MessengerController::class, 'index'])
        ->name('messenger.index');

    Route::get('/send-reports', [MessengerController::class, 'sendReports'])
        ->name('messenger.send-reports');

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

    Route::get('/katas/next-available', [ChallengeController::class, 'showNextChallengeAvailable'])
        ->name('katas.next-available');

    Route::get('/katas/change/{id}', [ChallengeController::class, 'changeChallenge'])
        ->name('katas.change');

    Route::get('/katas/{slug}', [ChallengeController::class, 'showKataMainPage'])
        ->name('katas.main-page');


    Route::post('/katas/{slug}/resource', [ResourceController::class, 'store'])
        ->name('katas.resource.store');

    Route::get('/katas/{slug}/get-resource/{id}/edit', [ResourceController::class, 'edit'])
        ->name('katas.resource.edit');

    Route::patch('/katas/{slug}/resource/{resource}', [ResourceController::class, 'update'])
        ->name('katas.resource.update');





    Route::get('/katas/{slug}/unlock-solutions', [SolutionController::class, 'unlockSolutions'])
        ->name('katas.unlock-solutions');

    Route::post('/katas/{slug}/verify-kata', [ChallengeController::class, 'verifyKata'])
        ->name('katas.verify');

    Route::get('/favorites', [FavoritesController::class, 'index'])
        ->name('katas.favorites');

    Route::put('favorites/{id}', [FavoritesController::class, 'store'])
        ->name('favorites.store');

    Route::delete('favorites/{id}', [FavoritesController::class, 'destroy'])
        ->name('favorites.destroy');
});
