<?php

namespace App\Infrastructure\Repository\Booking;

use App\Application\UseCase\Booking\DTO\UpdateBookingDTO;
use App\Domain\Booking\Booking;
use Illuminate\Support\Collection;

interface IBookingRepository
{
    public function save(Booking $booking, ?UpdateBookingDTO $updateBookingDTO): Booking;
    public function find(string $id): Booking;
    public function byRoom(?array $roomIds): Collection;
}
