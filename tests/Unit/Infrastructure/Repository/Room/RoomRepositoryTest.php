<?php

namespace Tests\Unit\Infrastructure\Repository\Room;

use App\Domain\Room\Room;
use App\Infrastructure\Repository\Room\RoomRepository;
use Tests\TestCase;

class RoomRepositoryTest extends TestCase
{
    public function test_find_room()
    {
        $this->artisan('migrate:refresh');

        $room = Room::create([
            'capacity' => 2
        ]);

        $repository = new RoomRepository();

        $response = $repository->find($room->id);

        $this->assertEquals($room->id, $response->id);
    }

    public function test_find_all_room()
    {
        $this->artisan('migrate:refresh');

        $room = Room::create([
            'capacity' => 2
        ]);

        $room2 = Room::create([
            'capacity' => 4
        ]);

        $repository = new RoomRepository();

        $rooms = $repository->findAll([$room->id, $room2->id]);

        $this->assertCount(2, $rooms);
        $this->assertEquals($rooms->first()->id, $room->id);
        $this->assertEquals($rooms->last()->id, $room2->id);
    }

    public function test_saves_room()
    {
        $this->artisan('migrate:refresh');

        $repository = new RoomRepository();

        $room = new Room([
            'capacity' => 4
        ]);

        $repository->save($room);
        $response = Room::first();

        $this->assertDatabaseCount('rooms', 1);
        $this->assertIsString($response->id);
        $this->assertNotNull($response->id);
        $this->assertEquals($room->capacity, $response->capacity);
   }
}
