<?php

namespace App\Domain\Room;

use App\Infrastructure\Repository\Room\IRoomRepository;
use Carbon\Carbon;

class TotalCapacityGetterService
{
    private IRoomRepository $roomRepository;

    public function __construct(IRoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    public function getDailyTotalCapacity(?array $rooms): int
    {
        $rooms = $this->roomRepository->findAll($rooms);
        return $rooms->sum('capacity');
    }

    public function getMonthlyTotalCapacity(?array $rooms, Carbon $date): int
    {
        $rooms = $this->roomRepository->findAll($rooms);
        return $rooms->sum('capacity') * $date->daysInMonth;
    }
}
