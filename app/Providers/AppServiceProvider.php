<?php

namespace App\Providers;

use App\Infrastructure\Repository\Booking\BlockRepository;
use App\Infrastructure\Repository\Booking\BookingRepository;
use App\Infrastructure\Repository\Booking\IBlockRepository;
use App\Infrastructure\Repository\Booking\IBookingRepository;
use App\Infrastructure\Repository\Room\IRoomRepository;
use App\Infrastructure\Repository\Room\RoomRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        IBookingRepository::class => BookingRepository::class,
        IRoomRepository::class => RoomRepository::class,
        IBlockRepository::class => BlockRepository::class
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
