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

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('customer.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('admin.bookings', function ($user) {
    return $user->role === 'admin';
});

Broadcast::channel('admin.rooms', function ($user) {
    return $user->role === 'admin';
});

Broadcast::channel('admin.dashboard', function ($user) {
    return $user->role === 'admin';
});