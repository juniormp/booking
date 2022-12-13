<?php

namespace App\Domain\Room;

use App\Infrastructure\Repository\Booking\IBlockRepository;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use DatePeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;

class BlockGetterService
{
    private IBlockRepository $blockRepository;

    public function __construct(IBlockRepository $blockRepository)
    {
        $this->blockRepository = $blockRepository;
    }

    public function getDailyBlock(?array $rooms, Carbon $filterDate): int
    {
        $blocks = $this->blockRepository->byRoom($rooms);
        return $this->dailyBlocks($blocks, $filterDate);
    }

    public function getMonthlyBlock(?array $rooms, Carbon $filterDate): int
    {
        $blocks = $this->blockRepository->byRoom($rooms);
        return $this->monthlyBlocks($blocks, $filterDate);
    }

    private function dailyBlocks(Collection $blocks, Carbon $filterDate): int
    {
        return $blocks->filter(function ($block) use ($filterDate) {
            $bookingDateStartsAt = Carbon::parse($block->starts_at);
            $bookingDateEndsAt = Carbon::parse($block->ends_at);

            $gte = $filterDate->gte($bookingDateStartsAt);
            $lte = $filterDate->lte($bookingDateEndsAt);

            return ($gte && $lte) ? $block : null;
        })->count();
    }

    private function monthlyBlocks(Collection $blocks, Carbon $filterDate): int
    {
        return $blocks->map(function($block) use ($filterDate) {
            $blockDateStartsAt = Carbon::parse($block->starts_at);
            $blockDateEndsAt = Carbon::parse($block->ends_at);

            $period = new DatePeriod($blockDateStartsAt, CarbonInterval::day(), $blockDateEndsAt);
            return iterator_count($period);
        })->sum();
    }
}
