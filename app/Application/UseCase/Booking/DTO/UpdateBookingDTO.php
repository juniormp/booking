<?php

namespace App\Application\UseCase\Booking\DTO;

/**
 * @property string $id
 * @property string $roomId
 * @property string $startsAt
 * @property string $endsAt
 */
class UpdateBookingDTO
{
    public function __construct(string $id, string $roomId, string $startsAt, string $endsAt)
    {
        $this->id = $id;
        $this->roomId = $roomId;
        $this->startsAt = $startsAt;
        $this->endsAt = $endsAt;
    }
}
