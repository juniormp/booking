<?php

namespace App\Application\UseCase\Booking\DTO;

/**
 * @property string $roomId
 * @property string $startsAt
 * @property string $endsAt
 */
class CreateBookingDTO
{
    public function __construct(string $room_id, string $startsAt, string $endsAt)
    {
        $this->roomId = $room_id;
        $this->startsAt = $startsAt;
        $this->endsAt = $endsAt;
    }
}
