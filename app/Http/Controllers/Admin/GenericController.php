<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGenericRequest;
use App\Http\Requests\Admin\UpdateGenericRequest;
use App\Models\Generic;

class GenericController extends Controller
{
    public function index()
    {
        $generics = Generic::latest()->paginate(15);
        return view('admin.generics.index', compact('generics'));
    }

    public function create()
    {
        return view('admin.generics.create');
    }

    public function store(StoreGenericRequest $request)
    {
        Generic::create($request->validated());
        return redirect()->route('admin.generics.index')->with('success', 'Generic created successfully.');
    }

    public function show(Generic $generic)
    {
        return view('admin.generics.show', compact('generic'));
    }

    public function edit(Generic $generic)
    {
        return view('admin.generics.edit', compact('generic'));
    }

    public function update(UpdateGenericRequest $request, Generic $generic)
    {
        $generic->update($request->validated());
        return redirect()->route('admin.generics.index')->with('success', 'Generic updated successfully.');
    }

    public function destroy(Generic $generic)
    {
        $generic->delete();
        return redirect()->route('admin.generics.index')->with('success', 'Generic deleted successfully.');
    }
}
