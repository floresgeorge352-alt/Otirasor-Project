<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
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

Broadcast::channel('availability', function () {
    return true;
});