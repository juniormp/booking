<?php

namespace App\Infrastructure\Repository\Booking;

use App\Application\UseCase\Booking\DTO\UpdateBookingDTO;
use App\Domain\Booking\Booking;
use Illuminate\Support\Collection;

class BookingRepository implements IBookingRepository
{
    public function save(Booking $booking, ?UpdateBookingDTO $updateBookingDTO): Booking
    {
        return Booking::updateOrCreate(
            [
                'id' => is_null($updateBookingDTO) ? null : $updateBookingDTO->id,
            ],
            [
                'room_id' => is_null($updateBookingDTO) ? $booking->room_id : $updateBookingDTO->roomId,
                'starts_at' => is_null($updateBookingDTO) ? $booking->starts_at : $updateBookingDTO->startsAt,
                'ends_at' => is_null($updateBookingDTO) ? $booking->ends_at : $updateBookingDTO->endsAt,
            ]
        );
    }

    public function find($id): Booking
    {
        return Booking::find($id);
    }

    public function byRoom(?array $roomIds): Collection
    {
        $query = Booking::query();

        if(!is_null($roomIds))
        {
            $query->whereIn('room_id', $roomIds);
        }

        return $query->get();
    }
}
