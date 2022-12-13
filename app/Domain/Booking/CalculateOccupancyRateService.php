<?php

namespace App\Domain\Booking;

class CalculateOccupancyRateService
{
    public function calculate(int $occupancy, int $totalCapacity, int $dailyBlocks): float
    {
        return round($occupancy / ($totalCapacity - $dailyBlocks), 2);
    }
}
