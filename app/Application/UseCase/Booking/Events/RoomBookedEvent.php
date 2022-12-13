<?php

namespace App\Application\UseCase\Booking\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoomBookedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $roomId;

    public function __construct(string $roomId)
    {
        $this->roomId = $roomId;
    }
}
