<?php

namespace Tests\Unit\Infrastructure\Repository\Booking;

use App\Application\UseCase\Booking\DTO\UpdateBookingDTO;
use App\Domain\Booking\Booking;
use App\Domain\Room\Room;
use App\Infrastructure\Repository\Booking\BookingRepository;
use Tests\TestCase;

class BookingRepositoryTest extends TestCase
{
    public function test_saves_booking()
    {
        $this->artisan('migrate:refresh');

        $room = Room::create([
            'capacity' => 2
        ]);

        $repository = new BookingRepository();

        $booking = new Booking([
            'room_id' => $room->id,
            'starts_at' =>  '2022-02-1 00:00:00',
            'ends_at' =>  '2022-02-2 00:00:00',
        ]);

        $booking = $repository->save($booking, null);

        $this->assertDatabaseCount('bookings', 1);
        $this->assertEquals($room->id, $booking->room_id);
        $this->assertEquals('2022-02-1 00:00:00', $booking->starts_at);
        $this->assertEquals('2022-02-2 00:00:00', $booking->ends_at);
    }

    public function test_updates_booking()
    {
        $this->artisan('migrate:refresh');

        $room = Room::create([
            'capacity' => 2
        ]);

        $roomB = Room::create([
            'capacity' => 2
        ]);

        $repository = new BookingRepository();

        $booking = Booking::create([
            'room_id' => $room->id,
            'starts_at' =>  '2022-02-1 00:00:00',
            'ends_at' =>  '2022-02-2 00:00:00',
        ]);

        $booking = $repository->save($booking, new UpdateBookingDTO(
            $booking->id,
            $roomB->id,
            '2022-02-10 00:00:00',
            '2022-02-20 00:00:00'
        ));

        $this->assertDatabaseCount('bookings', 1);
        $this->assertEquals($roomB->id, $booking->room_id);
        $this->assertEquals('2022-02-10 00:00:00', $booking->starts_at);
        $this->assertEquals('2022-02-20 00:00:00', $booking->ends_at);
    }
}
