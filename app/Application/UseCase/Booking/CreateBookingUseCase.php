<?php

namespace App\Application\UseCase\Booking;

use App\Application\UseCase\Booking\DTO\CreateBookingDTO;
use App\Application\UseCase\Booking\Events\RoomBookedEvent;
use App\Domain\Booking\Booking;
use App\Domain\Booking\BookingFactory;
use App\Domain\Room\RoomCapacityCheckerService;
use App\Infrastructure\Repository\Booking\IBookingRepository;

use Exception;

class CreateBookingUseCase {

    private BookingFactory $bookingFactory;
    private IBookingRepository $bookingRepository;
    private RoomCapacityCheckerService $roomCapacityCheckerService;

    public function __construct(
        BookingFactory             $bookingFactory,
        IBookingRepository         $bookingRepository,
        RoomCapacityCheckerService $roomCapacityCheckerService
    )
    {
        $this->bookingFactory = $bookingFactory;
        $this->bookingRepository = $bookingRepository;
        $this->roomCapacityCheckerService = $roomCapacityCheckerService;
    }

    public function execute(CreateBookingDTO $createBookingDTO) : Booking
    {
        $hasCapacity = $this->roomCapacityCheckerService->hasCapacity($createBookingDTO->roomId);
        throw_unless($hasCapacity, new Exception('Room has no longer capacity'));

        $booking = $this->bookingFactory->createBooking($createBookingDTO);
        $booking = $this->bookingRepository->save($booking, null);

        event(new RoomBookedEvent($createBookingDTO->roomId));

        return $booking;
    }
}
