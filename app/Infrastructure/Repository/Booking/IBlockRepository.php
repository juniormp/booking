<?php

namespace App\Infrastructure\Repository\Booking;

use Illuminate\Support\Collection;

interface IBlockRepository
{
    public function byRoom(array $roomIds): Collection;
}
