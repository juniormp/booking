<?php

namespace App\Infrastructure\Repository\Room;

use App\Domain\Room\Room;
use Illuminate\Support\Collection;

interface IRoomRepository
{
    public function find($id): Room;
    public function save(Room $room): void;
    public function findAll(?array $roomIds): Collection;
}
