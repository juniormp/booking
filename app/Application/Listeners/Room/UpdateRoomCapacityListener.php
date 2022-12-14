<?php

namespace App\Application\Listeners\Room;


use App\Application\UseCase\Booking\Events\RoomBookedEvent;
use App\Infrastructure\Repository\Room\IRoomRepository;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateRoomCapacityListener
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private IRoomRepository $roomRepository;

    public function __construct(IRoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    public function handle(RoomBookedEvent $event): void
    {
        $room = $this->roomRepository->find($event->roomId);

        $room->decreaseCapacity();
        $this->roomRepository->save($room);
    }
}
