<?php

namespace Tests\Unit\Http\Controllers\Booking\Request;

use App\Domain\Room\Room;
use App\Http\Controllers\Booking\Request\CreateBookingRequest;
use Illuminate\Support\Carbon;
use Tests\RequestValidatorHelper;
use Tests\TestCase;

class CreateBookingRequestTest extends TestCase
{
    use RequestValidatorHelper;

    private Room $room;

    public function setUp(): void
    {
        parent::setUp();
        $this->rules = (new CreateBookingRequest())->rules();
    }

    public function createFakeData()
    {
        $this->room = Room::create([
            'capacity' => 2
        ]);

        $dateToFreeze = Carbon::create(2022, 1, 01);
        Carbon::setTestNow($dateToFreeze);
    }

    public function test_room_id_validation_rule()
    {
        $this->artisan('migrate:refresh');

        $this->createFakeData();

        $this->assertTrue($this->validateField('room_id', $this->room->id));
        $this->assertFalse($this->validateField('room_id', 'ABC123'));
        $this->assertFalse($this->validateField('room_id', null));

        $this->assertTrue($this->validateField('starts_at', '2022-01-02'));
        $this->assertFalse($this->validateField('starts_at', null));
        $this->assertFalse($this->validateField('starts_at', '2022-01-02 15:15:15'));

        $this->assertTrue($this->validateField('ends_at', '2022-01-05'));
        $this->assertFalse($this->validateField('ends_at', '2022-01-02 15:15:15'));
        $this->assertFalse($this->validateField('ends_at', null));
    }
}
