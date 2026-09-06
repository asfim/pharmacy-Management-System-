<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('medicine')->id;
        return [
            'name'                  => 'required|string|max:255',
            'sku'                   => 'nullable|string|max:100|unique:products,sku,' . $id,
            'barcode'               => 'nullable|string|max:100|unique:products,barcode,' . $id,
            'generic_id'            => 'nullable|exists:generics,id',
            'brand_id'              => 'nullable|exists:brands,id',
            'manufacturer_id'       => 'nullable|exists:manufacturers,id',
            'category_id'           => 'nullable|exists:categories,id',
            'sub_category_id'       => 'nullable|exists:sub_categories,id',
            'unit_id'               => 'nullable|exists:units,id',
            'medicine_type'         => 'nullable|string|max:100',
            'strength'              => 'nullable|string|max:100',
            'dosage_form'           => 'nullable|string|max:100',
            'pack_size'             => 'nullable|string|max:100',
            'purchase_price'        => 'required|numeric|min:0',
            'sale_price'            => 'required|numeric|min:0',
            'wholesale_price'       => 'nullable|numeric|min:0',
            'mrp'                   => 'nullable|numeric|min:0',
            'tax'                   => 'nullable|numeric|min:0|max:100',
            'discount'              => 'nullable|numeric|min:0|max:100',
            'min_stock'             => 'nullable|integer|min:0',
            'reorder_level'         => 'nullable|integer|min:0',
            'prescription_required' => 'nullable|boolean',
            'description'           => 'nullable|string',
            'status'                => 'required|in:active,inactive',
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
