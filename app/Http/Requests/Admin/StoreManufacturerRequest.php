<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreManufacturerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            return ['name' => 'required|string|max:255|unique:manufacturers,name', 'address' => 'nullable|string|max:500', 'contact_person' => 'nullable|string|max:255', 'phone' => 'nullable|string|max:50', 'email' => 'nullable|email|max:255', 'website' => 'nullable|url|max:255', 'registration_no' => 'nullable|string|max:255', 'status' => 'required|in:active,inactive'];
        ];
    }
}

