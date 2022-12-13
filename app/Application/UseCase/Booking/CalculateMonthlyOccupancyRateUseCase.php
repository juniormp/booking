<?php

namespace App\Application\UseCase\Booking;


use App\Application\UseCase\Booking\DTO\CalculateMonthlyOccupancyRateDTO;
use App\Domain\Booking\CalculateOccupancyRateService;
use App\Domain\Room\BlockGetterService;
use App\Domain\Room\OccupancyGetterService;
use App\Domain\Room\TotalCapacityGetterService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;

class CalculateMonthlyOccupancyRateUseCase {

    private TotalCapacityGetterService $totalCapacityGetterService;
    private OccupancyGetterService $occupancyGetterService;
    private BlockGetterService $blockGetterService;
    private CalculateOccupancyRateService $calculateOccupancyRateService;

    public function __construct(
        TotalCapacityGetterService $totalCapacityGetterService,
        OccupancyGetterService $occupancyGetterService,
        BlockGetterService $blockGetterService,
        CalculateOccupancyRateService $calculateOccupancyRateService
    )
    {
        $this->totalCapacityGetterService = $totalCapacityGetterService;
        $this->occupancyGetterService = $occupancyGetterService;
        $this->blockGetterService = $blockGetterService;
        $this->calculateOccupancyRateService = $calculateOccupancyRateService;
    }

    public function execute(CalculateMonthlyOccupancyRateDTO $calculateMonthlyOccupancyRateDTO): float
    {
        $totalCapacity = $this->totalCapacityGetterService->getMonthlyTotalCapacity(
            $calculateMonthlyOccupancyRateDTO->rooms,
            Carbon::createFromFormat('Y-m', $calculateMonthlyOccupancyRateDTO->date)->startOfDay()
        );

        $monthlyOccupancy = $this->occupancyGetterService->getMonthlyOccupancy(
            $calculateMonthlyOccupancyRateDTO->rooms,
            Date::createFromFormat('Y-m', $calculateMonthlyOccupancyRateDTO->date)->startOfDay()
        );

        $monthlyBlocks = $this->blockGetterService->getMonthlyBlock(
            $calculateMonthlyOccupancyRateDTO->rooms,
            Date::createFromFormat('Y-m', $calculateMonthlyOccupancyRateDTO->date)->startOfDay()
        );

        return $this->calculateOccupancyRateService->calculate($monthlyOccupancy, $totalCapacity, $monthlyBlocks);
    }
}
