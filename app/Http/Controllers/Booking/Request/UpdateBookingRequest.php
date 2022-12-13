<?php

namespace App\Http\Controllers\Booking\Request;

use App\Http\Controllers\BaseRequest;

class UpdateBookingRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'string', 'exists:bookings,id'],
            'room_id' => ['required', 'string', 'exists:rooms,id'],
            'starts_at' => ['required', 'date_format:Y-m-d', 'after:now'],
            'ends_at' => ['required', 'date_format:Y-m-d', 'after:now'],
        ];
    }

    public function getData(): array
    {
        return array_merge($this->only(['id', 'room_id', 'starts_at', 'ends_at']));
    }
}
