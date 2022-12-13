<?php

namespace Tests\Unit\Infrastructure\Repository\Booking;

use App\Domain\Booking\Block;
use App\Domain\Room\Room;
use App\Infrastructure\Repository\Booking\BlockRepository;
use Carbon\Carbon;
use Tests\TestCase;

class BlockRepositoryTest extends TestCase
{
    public function test_find_block_by_room_and_date()
    {
        $this->artisan('migrate:refresh');

        $room = Room::create([
            'capacity' => 2
        ]);

        $block = Block::create([
            'room_id' => $room->id,
            'starts_at' => Carbon::createFromFormat('Y-m-d', '2022-01-01')->startOfDay(),
            'ends_at' => Carbon::createFromFormat('Y-m-d', '2022-01-10')->endOfDay(),
        ]);

        $repository = new BlockRepository();

        $blocks = $repository->byRoom([$room->id]);

        $this->assertCount(1, $blocks);
        $this->assertEquals($blocks->first()->id, $block->id);
    }

    public function test_find_blocks_by_room_and_date()
    {
        $this->artisan('migrate:refresh');

        $room = Room::create([
            'capacity' => 2
        ]);

        $block = Block::create([
            'room_id' => $room->id,
            'starts_at' => Carbon::createFromFormat('Y-m-d', '2022-01-01')->startOfDay(),
            'ends_at' => Carbon::createFromFormat('Y-m-d', '2022-01-10')->endOfDay(),
        ]);

        $room2 = Room::create([
            'capacity' => 4
        ]);

        $block2 = Block::create([
            'room_id' => $room2->id,
            'starts_at' => Carbon::createFromFormat('Y-m-d', '2022-01-20')->startOfDay(),
            'ends_at' => Carbon::createFromFormat('Y-m-d', '2022-01-30')->endOfDay(),
        ]);

        $repository = new BlockRepository();

        $blocks = $repository->byRoom([$room->id, $room2->id]);

        $this->assertCount(2, $blocks);
        $this->assertEquals($blocks->first()->id, $block->id);
        $this->assertEquals($blocks->last()->id, $block2->id);
    }
}
