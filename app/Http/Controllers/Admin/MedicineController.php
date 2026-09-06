<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMedicineRequest;
use App\Http\Requests\Admin\UpdateMedicineRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Generic;
use App\Models\Brand;
use App\Models\Manufacturer;
use App\Models\Unit;

class MedicineController extends Controller
{
    private function getFormData(): array
    {
        return [
            'categories'    => Category::all(),
            'subCategories' => SubCategory::all(),
            'generics'      => Generic::all(),
            'brands'        => Brand::all(),
            'manufacturers' => Manufacturer::all(),
            'units'         => Unit::all(),
            'medicineTypes' => [
                'Tablet', 'Capsule', 'Syrup', 'Injection', 'Cream', 'Ointment',
                'Drops', 'Inhaler', 'Spray', 'Powder', 'Suspension', 'Suppository',
                'Gel', 'Lotion',
            ],
        ];
    }

    public function index()
    {
        $medicines = Product::with(['category', 'brand', 'generic'])->latest()->paginate(15);
        return view('admin.medicines.index', compact('medicines'));
    }

    public function create()
    {
        return view('admin.medicines.create', $this->getFormData());
    }

    public function store(StoreMedicineRequest $request)
    {
        $data = $request->validated();
        $data['prescription_required'] = $request->boolean('prescription_required');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('medicines', 'public');
        }

        Product::create($data);
        return redirect()->route('admin.medicines.index')->with('success', 'Medicine added successfully.');
    }

    public function show(Product $medicine)
    {
        $medicine->load(['category', 'brand', 'generic', 'manufacturer', 'batches']);
        return view('admin.medicines.show', compact('medicine'));
    }

    public function edit(Product $medicine)
    {
        return view('admin.medicines.edit', array_merge(['medicine' => $medicine], $this->getFormData()));
    }

    public function update(UpdateMedicineRequest $request, Product $medicine)
    {
        $data = $request->validated();
        $data['prescription_required'] = $request->boolean('prescription_required');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('medicines', 'public');
        }

        $medicine->update($data);
        return redirect()->route('admin.medicines.index')->with('success', 'Medicine updated successfully.');
    }

    public function destroy(Product $medicine)
    {
        $medicine->delete();
        return redirect()->route('admin.medicines.index')->with('success', 'Medicine deleted successfully.');
    }
}
