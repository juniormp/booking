<?php

namespace Tests\Feature;

use App\Domain\Booking\Block;
use App\Domain\Booking\Booking;
use App\Domain\Room\Room;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class DailyOccupancyRatesTest extends TestCase
{
    public function test_get_daily_occupancy_for_all_rooms(): void
    {
        $this->artisan('migrate:refresh');

        $dateToFreeze = Carbon::create(2022, 1, 01);
        Carbon::setTestNow($dateToFreeze);

        $this->createFakeData();

        $response = $this->json('GET', '/api/booking/daily-occupancy-rates/2022-01-02');

        $response->assertJson([
            'occupancy_rate' => '0.36'
        ]);
    }

    public function test_get_daily_occupancy_for_rooms_b_and_c(): void
    {
        $this->artisan('migrate:refresh');

        $dateToFreeze = Carbon::create(2021, 1, 01);
        Carbon::setTestNow($dateToFreeze);

        $this->createFakeData();

        $response = $this->json('GET',
            '/api/booking/daily-occupancy-rates/2022-01-06?rooms[]=' . $this->roomB->id . '&rooms[]=' . $this->roomC->id
        );

        $response->assertJson([
            'occupancy_rate' => '0.2'
        ]);
    }

    public function createFakeData()
    {
        $this->roomA = Room::create([
            'capacity' => 6
        ]);

        $this->roomB = Room::create([
            'capacity' => 4
        ]);

        $this->roomC = Room::create([
            'capacity' => 2
        ]);

        $this->booking1 = Booking::create([
            'room_id' => $this->roomA->id,
            'starts_at' => '2022-01-01',
            'ends_at' => '2022-01-05'
        ]);

        $this->booking2 = Booking::create([
            'room_id' => $this->roomA->id,
            'starts_at' => '2022-01-01',
            'ends_at' => '2022-01-05'
        ]);

        $this->booking3 = Booking::create([
            'room_id' => $this->roomA->id,
            'starts_at' => '2022-01-01',
            'ends_at' => '2022-01-05'
        ]);

        $this->booking4 = Booking::create([
            'room_id' => $this->roomB->id,
            'starts_at' => '2022-01-01',
            'ends_at' => '2022-01-05'
        ]);

        $this->booking5 = Booking::create([
            'room_id' => $this->roomB->id,
            'starts_at' => '2022-01-03',
            'ends_at' => '2022-01-08'
        ]);

        Block::create([
            'room_id' => $this->roomB->id,
            'starts_at' => Carbon::createFromFormat('Y-m-d', '2022-01-01')->startOfDay(),
            'ends_at' => Carbon::createFromFormat('Y-m-d', '2022-01-10')->endOfDay(),
        ]);
    }
}
