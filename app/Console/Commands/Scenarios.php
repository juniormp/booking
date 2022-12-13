<?php

namespace App\Console\Commands;

use App\Domain\Booking\Block;
use App\Domain\Booking\Booking;
use App\Domain\Room\Room;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Scenarios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scenarios';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create scenariso for test';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call('migrate:refresh');

        // Room A
        $roomA = Room::create([
            'capacity' => 6
        ]);

        // Room B
        $roomB = Room::create([
            'capacity' => 4
        ]);

        // Room C
        $roomC = Room::create([
            'capacity' => 2
        ]);

        // Booking Room A
        Booking::create([
            'room_id' => $roomA->id,
            'starts_at' => Carbon::createFromFormat('Y-m-d', '2022-01-01')->startOfDay(),
            'ends_at' => Carbon::createFromFormat('Y-m-d', '2022-01-05')->endOfDay(),
        ]);

        Booking::create([
            'room_id' => $roomA->id,
            'starts_at' => Carbon::createFromFormat('Y-m-d', '2022-01-01')->startOfDay(),
            'ends_at' => Carbon::createFromFormat('Y-m-d', '2022-01-05')->endOfDay(),
        ]);

        Booking::create([
            'room_id' => $roomA->id,
            'starts_at' => Carbon::createFromFormat('Y-m-d', '2022-01-01')->startOfDay(),
            'ends_at' => Carbon::createFromFormat('Y-m-d', '2022-01-05')->endOfDay(),
        ]);

        Booking::create([
            'room_id' => $roomB->id,
            'starts_at' => Carbon::createFromFormat('Y-m-d', '2022-01-01')->startOfDay(),
            'ends_at' => Carbon::createFromFormat('Y-m-d', '2022-01-05')->endOfDay(),
        ]);

        Booking::create([
            'room_id' => $roomB->id,
            'starts_at' => Carbon::createFromFormat('Y-m-d', '2022-01-03')->startOfDay(),
            'ends_at' => Carbon::createFromFormat('Y-m-d', '2022-01-08')->endOfDay(),
        ]);

        // Block Room B
        Block::create([
            'room_id' => $roomB->id,
            'starts_at' => Carbon::createFromFormat('Y-m-d', '2022-01-01')->startOfDay(),
            'ends_at' => Carbon::createFromFormat('Y-m-d', '2022-01-10')->endOfDay(),
        ]);

        return Command::SUCCESS;
    }
}
