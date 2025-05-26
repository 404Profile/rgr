<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isManager());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address_ru' => 'required|string',
            'address_ru' => 'required|string',
            'address_en' => 'required|string',
            'map_latitude' => 'nullable|string|max:255',
            'map_longitude' => 'nullable|string|max:255',
            'social_links' => 'nullable|array',
            'working_hours_ru' => 'nullable|string|max:255',
            'working_hours_en' => 'nullable|string|max:255',
        ];
    }
}
