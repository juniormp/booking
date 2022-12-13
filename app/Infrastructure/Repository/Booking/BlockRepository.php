<?php

namespace App\Infrastructure\Repository\Booking;

use App\Domain\Booking\Block;
use Illuminate\Support\Collection;

class BlockRepository implements IBlockRepository
{
    public function byRoom(?array $roomIds): Collection
    {
        $query = Block::query();

        if(!is_null($roomIds))
        {
            $query->whereIn('room_id', $roomIds);
        }

        return $query->get();
    }
}
