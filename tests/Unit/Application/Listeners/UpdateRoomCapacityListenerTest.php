<?php

namespace Tests\Unit\Application\Listeners;

use App\Application\Listeners\Room\UpdateRoomCapacityListener;
use App\Application\UseCase\Booking\CreateBookingUseCase;
use App\Application\UseCase\Booking\DTO\CreateBookingDTO;
use App\Application\UseCase\Booking\Events\RoomBookedEvent;
use App\Domain\Booking\Booking;
use App\Domain\Booking\BookingFactory;
use App\Domain\Room\Room;
use App\Domain\Room\RoomCapacityCheckerService;
use App\Infrastructure\Repository\Booking\BookingRepository;
use App\Infrastructure\Repository\Room\IRoomRepository;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\TestCase;

class UpdateRoomCapacityListenerTest extends TestCase
{
    public function test_update_room_capacity(): void
    {
        $roomRepository = Mockery::mock(IRoomRepository::class);
        $subject = new UpdateRoomCapacityListener($roomRepository);
        $event = new RoomBookedEvent('123');
        $room = Mockery::mock(Room::class);

        $roomRepository
            ->shouldReceive()
            ->find(123)
            ->andReturn($room);

        $room
            ->shouldReceive('decreaseCapacity')
            ->once();

        $roomRepository
            ->shouldReceive()
            ->save($room);

        $subject->handle($event);
    }
}
