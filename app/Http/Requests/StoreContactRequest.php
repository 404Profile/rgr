<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'map_latitude' => 'nullable|string|max:255',
            'map_longitude' => 'nullable|string|max:255',
            'social_links' => 'nullable|array',
            'working_hours' => 'nullable|string|max:255',
        ];
    }
}
