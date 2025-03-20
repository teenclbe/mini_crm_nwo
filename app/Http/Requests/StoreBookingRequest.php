<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:15',
            'customer_email' => 'required|email',
            'room_ids' => 'required|array|min:1',
            'room_ids.*' => 'exists:rooms,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
        ];
    }
}