<?php

namespace Tests\Feature;

use App\Domain\Booking\Booking;
use App\Domain\Room\Room;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class UpdateBookingTest extends TestCase
{
    use DatabaseMigrations;

    public function test_update_booking(): void
    {
        parent::setUp();

        $dateToFreeze = Carbon::create(2021, 1, 01);
        Carbon::setTestNow($dateToFreeze);

        $this->createFakeData();

        $data = [
            'id' => $this->booking->id,
            'room_id' => $this->roomB->id,
            'starts_at' => '2022-01-02',
            'ends_at' => '2022-01-06',
        ];

        $response = $this->json('PUT', 'api/booking/updateBooking', $data);

        $response->assertJson([
            'id' => $this->booking->id,
            'room_id' => $this->roomB->id,
            'starts_at' => '2022-01-02',
            'ends_at' => '2022-01-06'
        ]);
        $this->assertDatabaseHas('bookings', [
            'id' => $this->booking->id,
            'room_id' => $this->roomB->id,
            'starts_at' => '2022-01-02',
            'ends_at' => '2022-01-06',
        ]);
    }

    public function createFakeData() {
        $this->roomA = Room::create([
            'capacity' => 6
        ]);

        $this->roomB = Room::create([
            'capacity' => 2
        ]);

        $this->booking = Booking::create([
            'room_id' => $this->roomA->id,
            'starts_at' => '2022-01-01',
            'ends_at' => '2022-01-05'
        ]);
    }
}
