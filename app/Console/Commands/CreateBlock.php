<?php

namespace App\Console\Commands;

use App\Domain\Booking\Block;
use App\Domain\Room\Room;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;

class CreateBlock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:block {room_id} {starts_at} {ends_at}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create and persist Block entity, starts_at and ends_at format is Y-m-d';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $startsAt = Date::createFromFormat('Y-m-d', $this->argument('starts_at'));
        $endsAt = Date::createFromFormat('Y-m-d', $this->argument('ends_at'));

        Block::create([
            'room_id' => $this->argument('room_id'),
            'starts_at' => $startsAt,
            'ends_at' => $endsAt
        ]);

        return Command::SUCCESS;
    }
}
