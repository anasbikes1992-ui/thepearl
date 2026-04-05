<?php

namespace App\Http\Requests\Kyc;

use Illuminate\Foundation\Http\FormRequest;

class StoreKycVerificationEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'uuid'],
            'provider' => ['required', 'string', 'max:80'],
            'event_type' => ['required', 'string', 'max:80'],
            'status' => ['required', 'string', 'max:40'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'payload' => ['nullable', 'array'],
        ];
    }
}