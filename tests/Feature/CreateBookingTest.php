<?php

namespace Tests\Feature;

use App\Domain\Room\Room;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class CreateBookingTest extends TestCase
{
    use DatabaseMigrations;

    public function test_create_booking(): void
    {
        parent::setUp();

        $dateToFreeze = Carbon::create(2021, 1, 01);
        Carbon::setTestNow($dateToFreeze);

        $this->createFakeData();

        $data = [
            'room_id' => $this->roomA->id,
            'starts_at' => '2022-01-01',
            'ends_at' => '2022-01-05',
        ];

        $response = $this->json('POST', 'api/booking/createBooking', $data);

        $this->assertDatabaseCount('rooms', 1);
        $response->assertJson([
            'room_id' => $this->roomA->id,
            'starts_at' => '2022-01-01',
            'ends_at' => '2022-01-05'
        ]);
    }

    public function createFakeData() {
        $this->roomA = Room::create([
            'capacity' => 6
        ]);
    }
}
