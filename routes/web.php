<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/bookings/calendar', [BookingController::class, 'showCalendar'])->name('bookings.calendar');

Route::get('/api/bookings/calendar', [BookingController::class, 'calendar'])->name('api.bookings.calendar');

Route::put('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');

Route::resource('rooms', RoomController::class);
Route::resource('bookings', BookingController::class);