<?php

namespace App\Http\Requests\Providers;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProviderProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'business_name' => ['required', 'string', 'max:180'],
            'verticals' => ['required', 'array', 'min:1'],
            'verticals.*' => ['string', 'max:64'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'phone' => ['nullable', 'string', 'max:30'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'supports_livestream' => ['sometimes', 'boolean'],
            'supports_resale' => ['sometimes', 'boolean'],
            'metadata' => ['nullable', 'array'],
        ];
    }
}