<?php

namespace App\Application\UseCase\Booking;


use App\Application\UseCase\Booking\DTO\CalculateDailyOccupancyRateDTO;
use App\Domain\Booking\CalculateOccupancyRateService;
use App\Domain\Room\BlockGetterService;
use App\Domain\Room\OccupancyGetterService;
use App\Domain\Room\TotalCapacityGetterService;
use Illuminate\Support\Facades\Date;

class CalculateDailyOccupancyRateUseCase {

    private TotalCapacityGetterService $totalCapacityGetterService;
    private OccupancyGetterService $dailyOccupancyGetterService;
    private BlockGetterService $blockGetterService;
    private CalculateOccupancyRateService $calculateOccupancyRateService;

    public function __construct(
        TotalCapacityGetterService    $totalCapacityGetterService,
        OccupancyGetterService        $dailyOccupancyGetterService,
        BlockGetterService            $blockGetterService,
        CalculateOccupancyRateService $calculateOccupancyRateService
    )
    {
        $this->totalCapacityGetterService = $totalCapacityGetterService;
        $this->dailyOccupancyGetterService = $dailyOccupancyGetterService;
        $this->blockGetterService = $blockGetterService;
        $this->calculateOccupancyRateService = $calculateOccupancyRateService;
    }

    public function execute(CalculateDailyOccupancyRateDTO $calculateDailyOccupancyRateDTO): float
    {
        $totalCapacity = $this->totalCapacityGetterService->getDailyTotalCapacity(
            $calculateDailyOccupancyRateDTO->rooms
        );

        $dailyOccupancy = $this->dailyOccupancyGetterService->getDailyOccupancy(
            $calculateDailyOccupancyRateDTO->rooms,
            Date::createFromFormat('Y-m-d', $calculateDailyOccupancyRateDTO->date)->startOfDay()
        );

        $dailyBlocks = $this->blockGetterService->getDailyBlock(
            $calculateDailyOccupancyRateDTO->rooms,
            Date::createFromFormat('Y-m-d', $calculateDailyOccupancyRateDTO->date)->startOfDay()
        );

        return $this->calculateOccupancyRateService->calculate($dailyOccupancy, $totalCapacity, $dailyBlocks);
    }
}
