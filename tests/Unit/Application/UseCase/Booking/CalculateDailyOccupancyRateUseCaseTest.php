<?php

namespace Tests\Unit\Application\UseCase\Booking;

use App\Application\UseCase\Booking\CalculateDailyOccupancyRateUseCase;
use App\Application\UseCase\Booking\DTO\CalculateDailyOccupancyRateDTO;
use App\Domain\Booking\CalculateOccupancyRateService;
use App\Domain\Room\BlockGetterService;
use App\Domain\Room\OccupancyGetterService;
use App\Domain\Room\TotalCapacityGetterService;
use Mockery;
use Tests\TestCase;

class CalculateDailyOccupancyRateUseCaseTest extends TestCase
{
    public function test_calculate_daily_occupancy_rate(): void
    {
        $totalCapacityGetterService = Mockery::mock(TotalCapacityGetterService::class);
        $occupancyGetterService = Mockery::mock(OccupancyGetterService::class);
        $blockGetterService = Mockery::mock(BlockGetterService::class);
        $calculateOccupancyRateService = Mockery::mock(CalculateOccupancyRateService::class);
        $totalCapacity = 12;
        $dailyOccupancy = 5;
        $dailyBlocks = 10;
        $occupancyRate = 0.6;

        $subject = new CalculateDailyOccupancyRateUseCase(
            $totalCapacityGetterService,
            $occupancyGetterService,
            $blockGetterService,
            $calculateOccupancyRateService
        );

        $calculateDailyOccupancyRateDTO = new CalculateDailyOccupancyRateDTO('2022-01-01', ["123"]);

        $totalCapacityGetterService->shouldReceive('getDailyTotalCapacity')->with(
            $calculateDailyOccupancyRateDTO->rooms
        )->andReturn($totalCapacity)->once();
        $occupancyGetterService->shouldReceive('getDailyOccupancy')->andReturn($dailyOccupancy)->once();
        $blockGetterService->shouldReceive('getDailyBlock')->andReturn($dailyBlocks)->once();
        $calculateOccupancyRateService->shouldReceive('calculate')
            ->with($dailyOccupancy, $totalCapacity , $dailyBlocks)
            ->andReturn($occupancyRate)
            ->once();

        $response = $subject->execute($calculateDailyOccupancyRateDTO);

        $this->assertEquals($occupancyRate, $response);
    }
}
