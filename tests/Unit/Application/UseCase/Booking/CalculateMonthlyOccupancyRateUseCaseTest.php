<?php

namespace Tests\Unit\Application\UseCase\Booking;

use App\Application\UseCase\Booking\CalculateMonthlyOccupancyRateUseCase;
use App\Application\UseCase\Booking\DTO\CalculateMonthlyOccupancyRateDTO;
use App\Domain\Booking\CalculateOccupancyRateService;
use App\Domain\Room\BlockGetterService;
use App\Domain\Room\OccupancyGetterService;
use App\Domain\Room\TotalCapacityGetterService;
use Mockery;
use Tests\TestCase;

class CalculateMonthlyOccupancyRateUseCaseTest extends TestCase
{
    public function test_calculate_monthly_occupancy_rate(): void
    {
        $totalCapacityGetterService = Mockery::mock(TotalCapacityGetterService::class);
        $occupancyGetterService = Mockery::mock(OccupancyGetterService::class);
        $blockGetterService = Mockery::mock(BlockGetterService::class);
        $calculateOccupancyRateService = Mockery::mock(CalculateOccupancyRateService::class);
        $totalCapacity = 12;
        $monthlyOccupancy = 5;
        $monthlyBlocks = 10;
        $occupancyRate = 0.6;

        $subject = new CalculateMonthlyOccupancyRateUseCase(
            $totalCapacityGetterService,
            $occupancyGetterService,
            $blockGetterService,
            $calculateOccupancyRateService
        );

        $calculateMonthlyOccupancyRateDTO = new CalculateMonthlyOccupancyRateDTO('2022-01', []);

        $totalCapacityGetterService->shouldReceive('getMonthlyTotalCapacity')->andReturn($totalCapacity)->once();
        $occupancyGetterService->shouldReceive('getMonthlyOccupancy')->andReturn($monthlyOccupancy)->once();
        $blockGetterService->shouldReceive('getMonthlyBlock')->andReturn($monthlyBlocks)->once();
        $calculateOccupancyRateService->shouldReceive('calculate')
            ->with($monthlyOccupancy, $totalCapacity , $monthlyBlocks)
            ->andReturn($occupancyRate)
            ->once();

        $response = $subject->execute($calculateMonthlyOccupancyRateDTO);

        $this->assertEquals($occupancyRate, $response);
    }
}
