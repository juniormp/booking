<?php

namespace Tests\Unit\Application\UseCase\Booking;

use App\Application\UseCase\Booking\DTO\UpdateBookingDTO;
use App\Application\UseCase\Booking\UpdateBookingUseCase;
use App\Domain\Booking\Booking;
use App\Infrastructure\Repository\Booking\BookingRepository;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\TestCase;

class UpdateBookingUseCaseTest extends TestCase
{
    public function test_updates_booking(): void
    {
        Event::fake();

       $bookingRepository = Mockery::mock(BookingRepository::class);
       $subject = new UpdateBookingUseCase($bookingRepository);
       $updateBookingDTO = new UpdateBookingDTO("123", "123", "2022-01-01", "2022-01-01");
       $booking = Mockery::mock(Booking::class);

        $bookingRepository
           ->shouldReceive('find')
           ->with($updateBookingDTO->id)
           ->andReturn($booking)
           ->once();

        $bookingRepository
            ->shouldReceive('save')
            ->with($booking, $updateBookingDTO)
            ->andReturn($booking)
            ->once();

       $response = $subject->execute($updateBookingDTO);

       $this->assertEquals($booking, $response);
    }
}
