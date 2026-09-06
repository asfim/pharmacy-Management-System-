<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreManufacturerRequest;
use App\Http\Requests\Admin\UpdateManufacturerRequest;
use App\Models\Manufacturer;

class ManufacturerController extends Controller
{
    public function index()
    {
        $manufacturers = Manufacturer::latest()->paginate(15);
        return view('admin.manufacturers.index', compact('manufacturers'));
    }

    public function create()
    {
        return view('admin.manufacturers.create');
    }

    public function store(StoreManufacturerRequest $request)
    {
        $data = $request->validated();
        // map form field to model column
        if (isset($data['registration_no'])) {
            $data['license_info'] = $data['registration_no'];
            unset($data['registration_no']);
        }
        // the 'name' field from form maps to company_name
        if (isset($data['name'])) {
            $data['company_name'] = $data['name'];
            unset($data['name']);
        }
        Manufacturer::create($data);
        return redirect()->route('admin.manufacturers.index')->with('success', 'Manufacturer created successfully.');
    }

    public function show(Manufacturer $manufacturer)
    {
        return view('admin.manufacturers.show', compact('manufacturer'));
    }

    public function edit(Manufacturer $manufacturer)
    {
        return view('admin.manufacturers.edit', compact('manufacturer'));
    }

    public function update(UpdateManufacturerRequest $request, Manufacturer $manufacturer)
    {
        $data = $request->validated();
        if (isset($data['registration_no'])) {
            $data['license_info'] = $data['registration_no'];
            unset($data['registration_no']);
        }
        if (isset($data['name'])) {
            $data['company_name'] = $data['name'];
            unset($data['name']);
        }
        $manufacturer->update($data);
        return redirect()->route('admin.manufacturers.index')->with('success', 'Manufacturer updated successfully.');
    }

    public function destroy(Manufacturer $manufacturer)
    {
        $manufacturer->delete();
        return redirect()->route('admin.manufacturers.index')->with('success', 'Manufacturer deleted successfully.');
    }
}
