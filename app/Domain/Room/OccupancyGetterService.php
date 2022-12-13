<?php

namespace App\Domain\Room;

use App\Domain\Booking\Booking;
use App\Infrastructure\Repository\Booking\IBookingRepository;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use DatePeriod;
use Illuminate\Support\Collection;

class OccupancyGetterService
{
    private IBookingRepository $bookingRepository;

    public function __construct(IBookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function getDailyOccupancy(?array $rooms, Carbon $filterDate): int
    {
        $bookings = $this->bookingRepository->byRoom($rooms);
        return $this->dailyOccupancy($bookings, $filterDate);
    }

    public function getMonthlyOccupancy(?array $rooms, Carbon $filterDate): int
    {
        $bookings = $this->bookingRepository->byRoom($rooms);
        return $bookings->map(function($booking) use ($filterDate) {
            $bookingDateStartsAt = Carbon::parse($booking->starts_at)->startOfDay();
            $bookingDateEndsAt = Carbon::parse($booking->ends_at)->endOfDay();

            $period = new DatePeriod($bookingDateStartsAt, CarbonInterval::day(), $bookingDateEndsAt);
            return iterator_count($period);
        })->sum();
    }

    private function dailyOccupancy(Collection $bookings, Carbon $filterDate): int
    {
        return $bookings->filter(function (Booking $booking) use ($filterDate) {
            $bookingDateStartsAt = Carbon::parse($booking->starts_at)->startOfDay();
            $bookingDateEndsAt = Carbon::parse($booking->ends_at)->endOfDay();

            $gte = $filterDate->gte($bookingDateStartsAt);
            $lte = $filterDate->lte($bookingDateEndsAt);

            return ($gte && $lte) ? $booking : null;
        })->count();
    }
}
