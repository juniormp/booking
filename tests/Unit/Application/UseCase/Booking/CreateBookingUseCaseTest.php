<?php

namespace Tests\Unit\Application\UseCase\Booking;

use App\Application\UseCase\Booking\CreateBookingUseCase;
use App\Application\UseCase\Booking\DTO\CreateBookingDTO;
use App\Application\UseCase\Booking\Events\RoomBookedEvent;
use App\Domain\Booking\Booking;
use App\Domain\Booking\BookingFactory;
use App\Domain\Room\RoomCapacityCheckerService;
use App\Infrastructure\Repository\Booking\BookingRepository;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\TestCase;

class CreateBookingUseCaseTest extends TestCase
{
    public function test_creates_booking(): void
    {
        Event::fake();

       $bookingFactory = Mockery::mock(BookingFactory::class);
       $bookingRepository = Mockery::mock(BookingRepository::class);
       $roomCapacityChecker = Mockery::mock(RoomCapacityCheckerService::class);
       $subject = new CreateBookingUseCase(
           $bookingFactory,
           $bookingRepository,
           $roomCapacityChecker
       );
       $createBookingDTO = new CreateBookingDTO("123", "2022-01-01", "2022-01-01");
       $booking = Mockery::mock(Booking::class);

       $roomCapacityChecker
           ->shouldReceive('hasCapacity')
           ->with($createBookingDTO->roomId)
           ->andReturn(true)
           ->once();

       $bookingFactory
           ->shouldReceive('createBooking')
           ->with($createBookingDTO)
           ->andReturn($booking)
           ->once();

       $bookingRepository
           ->shouldReceive('save')
           ->with($booking, null)
           ->andReturn($booking)
           ->once();

       $response = $subject->execute($createBookingDTO);

        Event::assertDispatched(RoomBookedEvent::class, function ($e) use ($createBookingDTO) {
            return $e->roomId === $createBookingDTO->roomId;
        });

       $this->assertEquals($booking, $response);
    }

    public function test_throws_error_if_room_has_no_longer_capacity(): void
    {
        Event::fake();

        $bookingFactory = Mockery::mock(BookingFactory::class);
        $bookingRepository = Mockery::mock(BookingRepository::class);
        $roomCapacityChecker = Mockery::mock(RoomCapacityCheckerService::class);
        $subject = new CreateBookingUseCase(
            $bookingFactory,
            $bookingRepository,
            $roomCapacityChecker
        );
        $createBookingDTO = new CreateBookingDTO("123", "2022-01-01", "2022-01-01");

        $roomCapacityChecker
            ->shouldReceive('hasCapacity')
            ->with($createBookingDTO->roomId)
            ->andReturn(false)
            ->once();

        $bookingFactory->shouldNotReceive('createBooking');

        $bookingRepository->shouldNotReceive('save');

        $this->expectExceptionMessage('Room has no longer capacity');

        $subject->execute($createBookingDTO);

        Event::assertNotDispatched(RoomBookedEvent::class);
   }
}
