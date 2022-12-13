<?php

namespace Tests\Unit\Http\Controllers\Booking\Request;

use App\Domain\Booking\Booking;
use App\Domain\Room\Room;
use App\Http\Controllers\Booking\Request\DailyOccupancyRatesRequest;
use Illuminate\Support\Carbon;
use Tests\RequestValidatorHelper;
use Tests\TestCase;

class DailyOccupancyRatesRequestTest extends TestCase
{
    use RequestValidatorHelper;

    private Room $room;
    private Booking $booking;

    public function setUp(): void
    {
        parent::setUp();
        $this->rules = (new DailyOccupancyRatesRequest())->rules();
    }

    public function createFakeData()
    {
        $dateToFreeze = Carbon::create(2022, 1, 01);
        Carbon::setTestNow($dateToFreeze);

        $this->room = Room::create([
            'capacity' => 6
        ]);
    }

    public function test_room_id_validation_rule()
    {
        $this->artisan('migrate:refresh');

        $this->createFakeData();

        $this->assertTrue($this->validateField('date', '2022-02-01'));
        $this->assertFalse($this->validateField('date', '2022-02'));
        $this->assertFalse($this->validateField('date', ''));
        $this->assertFalse($this->validateField('date', null));

        $this->assertTrue($this->validateField('rooms', null));
        $this->assertTrue($this->validateField('rooms.*', $this->room->id));
    }
}
