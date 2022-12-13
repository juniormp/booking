<?php

namespace App\Domain\Room;

use App\Infrastructure\Repository\Room\IRoomRepository;

class RoomCapacityCheckerService
{
    private IRoomRepository $roomRepository;
    private int $minCapacity = 1;

    public function __construct(IRoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    public function hasCapacity(string $roomId): bool
    {
        $room = $this->roomRepository->find($roomId);

        return $room->capacity >= $this->minCapacity;
    }
}
