<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Base Model
// ----------
// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

// Private Channel for authenticated users theme changes.
Broadcast::channel('theme.user.{id}', function($user, $id) {
    return (int) $user->id === (int) $id;
});

// Public Channel for unauthenticated users theme changes.
// It differentiates and recognizes them by the csrf token of the session.
Broadcast::channel('theme.{token}', function($token) {
    return session('_token') === $token;
});
