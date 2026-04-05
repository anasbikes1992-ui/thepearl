<?php

namespace App\Http\Requests\Bookings;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'listing_id' => ['required', 'uuid'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after_or_equal:starts_at'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:100'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'metadata' => ['nullable', 'array'],
        ];
    }
}
