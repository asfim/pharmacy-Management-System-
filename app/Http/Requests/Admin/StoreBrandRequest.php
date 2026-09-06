<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
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
            return ['name' => 'required|string|max:255|unique:brands,name', 'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 'description' => 'nullable|string|max:1000', 'status' => 'required|in:active,inactive'];
        ];
    }
}

