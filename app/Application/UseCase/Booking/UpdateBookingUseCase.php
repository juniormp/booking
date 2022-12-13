<?php

namespace App\Application\UseCase\Booking;


use App\Application\UseCase\Booking\DTO\UpdateBookingDTO;
use App\Domain\Booking\Booking;
use App\Infrastructure\Repository\Booking\BookingRepository;
use App\Infrastructure\Repository\Booking\IBookingRepository;

class UpdateBookingUseCase {

    private BookingRepository $bookingRepository;

    public function __construct(
        IBookingRepository $bookingRepository
    )
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function execute(UpdateBookingDTO $updateBookingDTO) : Booking
    {
        $booking = $this->bookingRepository->find($updateBookingDTO->id);
        return $this->bookingRepository->save($booking, $updateBookingDTO);
    }
}
