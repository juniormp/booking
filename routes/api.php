<?php

use App\Http\Controllers\Booking\BookingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('booking')->group(function () {
    Route::get('daily-occupancy-rates/{date}', [BookingController::class, 'calculateDailyOccupancyRate']);
    Route::get('monthly-occupancy-rates/{date}', [BookingController::class, 'calculateMonthlyOccupancyRate']);

    Route::post('createBooking', [BookingController::class, 'createBooking']);

    Route::put('updateBooking', [BookingController::class, 'updateBooking']);
});
