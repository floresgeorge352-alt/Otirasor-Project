<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    \App\Models\ReservationHold::expireStale();
})->everyMinute()->name('expire-reservation-holds');

Schedule::command('db:backup --cleanup')
    ->dailyAt('02:00')
    ->withoutOverlapping()
    ->appendOutputTo(storage_path('logs/backup.log'));

// === BAGONG IDINAGDAG: Booking Reminders ===
Schedule::command('reminders:bookings')
    ->dailyAt('08:00')
    ->appendOutputTo(storage_path('logs/reminders.log'));