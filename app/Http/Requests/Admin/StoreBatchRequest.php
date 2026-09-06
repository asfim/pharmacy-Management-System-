<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreBatchRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'product_id'         => 'required|exists:products,id',
            'batch_no'           => 'required|string|max:100',
            'manufacturing_date' => 'nullable|date',
            'expiry_date'        => 'nullable|date|after_or_equal:manufacturing_date',
            'purchase_price'     => 'required|numeric|min:0',
            'sale_price'         => 'required|numeric|min:0',
            'quantity'           => 'required|integer|min:0',
        ];
    }
}
