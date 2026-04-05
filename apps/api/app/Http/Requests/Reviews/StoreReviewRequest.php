<?php

namespace App\Http\Requests\Reviews;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'provider_user_id' => ['required', 'uuid'],
            'booking_id' => ['nullable', 'uuid'],
            'rating' => ['required', 'numeric', 'min:1', 'max:5'],
            'title' => ['required', 'string', 'max:180'],
            'body' => ['required', 'string', 'min:10', 'max:3000'],
            'metadata' => ['nullable', 'array'],
        ];
    }
}