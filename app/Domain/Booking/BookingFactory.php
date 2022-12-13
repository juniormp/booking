<?php

namespace App\Domain\Booking;

use App\Application\UseCase\Booking\DTO\CreateBookingDTO;

class BookingFactory
{
    public function createBooking(CreateBookingDTO $createBookingDTO): Booking
    {
        return new Booking([
            'room_id' => $createBookingDTO->roomId,
            'starts_at' =>  $createBookingDTO->startsAt,
            'ends_at' =>  $createBookingDTO->endsAt
        ]);
    }
}
