<?php

namespace App\Http\Requests\Listings;

use App\Enums\Listing\Vertical;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'vertical' => ['required', Rule::enum(Vertical::class)],
            'title' => ['required', 'string', 'min:3', 'max:180'],
            'description' => ['required', 'string', 'min:10', 'max:5000'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'district' => ['required', 'string', 'max:120'],
            'city' => ['required', 'string', 'max:120'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'metadata' => ['nullable', 'array'],
        ];
    }
}
