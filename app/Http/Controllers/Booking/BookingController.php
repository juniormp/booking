<?php

namespace App\Http\Controllers\Booking;

use App\Application\UseCase\Booking\CalculateDailyOccupancyRateUseCase;
use App\Application\UseCase\Booking\CalculateMonthlyOccupancyRateUseCase;
use App\Application\UseCase\Booking\CreateBookingUseCase;
use App\Application\UseCase\Booking\DTO\CalculateDailyOccupancyRateDTO;
use App\Application\UseCase\Booking\DTO\CalculateMonthlyOccupancyRateDTO;
use App\Application\UseCase\Booking\DTO\CreateBookingDTO;
use App\Application\UseCase\Booking\DTO\UpdateBookingDTO;
use App\Application\UseCase\Booking\UpdateBookingUseCase;
use App\Domain\Booking\Booking;
use App\Http\Controllers\Booking\Request\CreateBookingRequest;
use App\Http\Controllers\Booking\Request\DailyOccupancyRatesRequest;
use App\Http\Controllers\Booking\Request\MonthlyOccupancyRatesRequest;
use App\Http\Controllers\Booking\Request\UpdateBookingRequest;
use App\Http\Controllers\Controller;


class BookingController extends Controller
{

    private CreateBookingUseCase $createBooking;
    private UpdateBookingUseCase $updateBooking;
    private CalculateDailyOccupancyRateUseCase $calculateDailyOccupancyRate;
    private CalculateMonthlyOccupancyRateUseCase $calculateMonthlyOccupancyRate;

    public function __construct(
        CreateBookingUseCase $createBooking,
        UpdateBookingUseCase $updateBooking,
        CalculateDailyOccupancyRateUseCase $calculateDailyOccupancyRate,
        CalculateMonthlyOccupancyRateUseCase $calculateMonthlyOccupancyRate
    )
    {
        $this->createBooking = $createBooking;
        $this->updateBooking = $updateBooking;
        $this->calculateDailyOccupancyRate = $calculateDailyOccupancyRate;
        $this->calculateMonthlyOccupancyRate = $calculateMonthlyOccupancyRate;
    }

    public function calculateDailyOccupancyRate(DailyOccupancyRatesRequest $request): array
    {
        $calculateDailyOccupancyRateDTO = new CalculateDailyOccupancyRateDTO(
            $request->getData()['date'],
            $request->getData()['rooms']
        );

        $occupancyRate = $this->calculateDailyOccupancyRate->execute($calculateDailyOccupancyRateDTO);

        return [
            'occupancy_rate' => $occupancyRate
        ];
    }

    public function calculateMonthlyOccupancyRate(MonthlyOccupancyRatesRequest $request): array
    {
        $calculateMonthlyOccupancyRateDTO = new CalculateMonthlyOccupancyRateDTO(
            $request->getData()['date'],
            $request->getData()['rooms']
        );

        $monthlyRate = $this->calculateMonthlyOccupancyRate->execute($calculateMonthlyOccupancyRateDTO);

        return [
            'occupancy_rate' => $monthlyRate
        ];
    }

    public function createBooking(CreateBookingRequest $request): Booking
    {
        $crateBookingDTO = new CreateBookingDTO(
            $request->getData()['room_id'],
            $request->getData()['starts_at'],
            $request->getData()['ends_at']
        );

        return $this->createBooking->execute($crateBookingDTO);
    }

    public function updateBooking(UpdateBookingRequest $updateBookingRequest): Booking
    {
        $updateBookingDTO = new UpdateBookingDTO(
            $updateBookingRequest->getData()['id'],
            $updateBookingRequest->getData()['room_id'],
            $updateBookingRequest->getData()['starts_at'],
            $updateBookingRequest->getData()['ends_at']
        );

        return $this->updateBooking->execute($updateBookingDTO);
    }
}
