<?php

namespace App\Application\UseCase\Booking\DTO;

/**
 * @property string $date
 * @property array $rooms
 */
class CalculateMonthlyOccupancyRateDTO
{
    public function __construct(string $date, ?array $rooms)
    {
        $this->date = $date;
        $this->rooms = $rooms;
    }
}
