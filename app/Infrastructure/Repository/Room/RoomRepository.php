<?php

namespace App\Infrastructure\Repository\Room;

use App\Domain\Room\Room;
use Illuminate\Support\Collection;

class RoomRepository implements IRoomRepository
{
    public function find($id): Room
    {
        return Room::find($id);
    }

    public function save(Room $room): void
    {
        $room->save();
    }

    public function findAll(?array $roomIds): Collection
    {
        $query = Room::query();

        if(!is_null($roomIds))
        {
            $query->whereIn('id', $roomIds);
        }

        return $query->get();
    }
}
