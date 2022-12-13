<?php

namespace App\Console\Commands;

use App\Domain\Room\Room;
use Illuminate\Console\Command;

class CreateRoom extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:room {capacity=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create and persist Room entity';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Room::create([
            'capacity' => $this->argument('capacity')
        ]);

        return Command::SUCCESS;
    }
}
