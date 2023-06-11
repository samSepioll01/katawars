<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
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
        return redirect()->route('admin.panel');
    });

    Route::get('/panel', function() {
        return view('admin.admin-panel');
    })->name('admin.panel');

    Route::resource('users', UserController::class)
        ->middleware('role:superadmin');

    Route::delete('/users/{user:id}', [UserController::class, 'destroy'])
        ->name('users.destroy')
        ->middleware('role:superadmin');

    Route::get('/users/banned/index', [UserController::class, 'showBanned'])
        ->name('users.banned')
        ->middleware('role:superadmin');

    Route::post('users/recovery/{user:id}', [UserController::class, 'recoveryBanned'])
        ->name('users.recovery')
        ->middleware('role:superadmin');

    Route::delete('/users/banned/{user}', [UserController::class, 'toBan'])
        ->name('users.toban')
        ->middleware('role:superadmin');



    Route::post('/users/{user}/edit/delete-photos/{index}', [UserController::class, 'deletePhoto'])
        ->name('users.delete.photo')
        ->middleware('role:superadmin');

    Route::get('/users/change/{id}', [UserController::class, 'changeUser'])
        ->name('users.change')
        ->middleware('role:superadmin');

    Route::get('/users/{user}/challenges', [UserController::class, 'showCreatedChallenges'])
        ->name('users.challenges')
        ->middleware('role:superadmin');

    Route::get('/users/{user}/comments', [UserController::class, 'showComments'])
        ->name('users.comments')
        ->middleware('role:superadmin');

    Route::get('/users/{user}/comments/{comment:id}', [UserController::class, 'showComment'])
        ->name('users.comments.show')
        ->middleware('role:superadmin');

    Route::delete('/users/{user}/comments/{comment:id}', [CommentController::class, 'deleteUserComment'])
        ->name('users.comments.destroy')
        ->middleware('role:superadmin');

    Route::post('/users/{user}/comments/destroy-multiple', [CommentController::class, 'destroyMultipleComment'])
        ->name('users.comments.destroy-multiple')
        ->middleware('role:superadmin');

    Route::get('/users/{user}/resources', [ResourceController::class, 'showUserResources'])
        ->name('users.resources')
        ->middleware('role:superadmin');

    Route::get('/users/{user}/resources/{resource:id}', [ResourceController::class, 'showUserResource'])
        ->name('users.resources.show')
        ->middleware('role:superadmin');

    Route::delete('/users/{user}/resources/{resource:id}', [ResourceController::class, 'deleteUserResource'])
        ->name('users.resources.destroy')
        ->middleware('role:superadmin');

    Route::post('/users/{user}/comments/destroy-multiple', [ResourceController::class, 'destroyMultipleResources'])
        ->name('users.resources.destroy-multiple')
        ->middleware('role:superadmin');

    Route::get('/users/{user}/challenges/{challenge:id}', [UserController::class, 'showCreatedChallenge'])
        ->name('users.challenges.show')
        ->middleware('role:superadmin');

    Route::delete('/users/{user}/challenges/delete-multiple', [ChallengeController::class, 'deleteMultiple'])
        ->name('users.challenges.delete-multiple')
        ->middleware('role:superadmin');

    Route::delete('/users/{user}/challenges/{challenge:id}', [ChallengeController::class, 'destroy'])
        ->name('users.challenges.destroy')
        ->middleware('role:superadmin');





    Route::resource('roles', RoleController::class)
        ->middleware('role:superadmin');


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

    Route::delete('/katas/{challenge:slug}/resource/{resource:id}', [ResourceController::class, 'destroy'])
        ->name('katas.resource.destroy');

    Route::get('/katas/{slug}/unlock-solutions', [SolutionController::class, 'unlockSolutions'])
        ->name('katas.unlock-solutions');

    Route::delete('katas/{challenge:slug}/solution/{solution:id}', [SolutionController::class, 'destroy'])
        ->name('katas.solution.destroy');

    Route::post('/katas/{slug}/verify-kata', [ChallengeController::class, 'verifyKata'])
        ->name('katas.verify');

    Route::get('/favorites', [FavoritesController::class, 'index'])
        ->name('katas.favorites');

    Route::put('favorites/{id}', [FavoritesController::class, 'store'])
        ->name('favorites.store');

    Route::delete('favorites/{id}', [FavoritesController::class, 'destroy'])
        ->name('favorites.destroy');
});
