<?php

namespace App\Http\Controllers\Booking\Request;

use App\Http\Controllers\BaseRequest;
use Illuminate\Support\Facades\Route;

class DailyOccupancyRatesRequest extends BaseRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => ['required', 'date_format:Y-m-d'],
            'rooms' => ['array', 'nullable'],
            'rooms.*' => ['exists:rooms,id']
        ];
    }

    public function validationData(): array
    {
        return array_merge($this->request->all(), [
            'date' => Route::input('date'),
            'rooms' => request('rooms')
        ]);
    }

    public function getData(): array
    {
        return [
            'date' => Route::input('date'),
            'rooms' => request('rooms')
        ];
    }
}
