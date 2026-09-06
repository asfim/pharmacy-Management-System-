<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBatchRequest;
use App\Http\Requests\Admin\UpdateBatchRequest;
use App\Models\Batch;
use App\Models\Product;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::with('product')->latest()->paginate(15);
        return view('admin.batches.index', compact('batches'));
    }

    public function create()
    {
        $medicines = Product::all();
        return view('admin.batches.create', compact('medicines'));
    }

    public function store(StoreBatchRequest $request)
    {
        Batch::create($request->validated());
        return redirect()->route('admin.batches.index')->with('success', 'Batch created successfully.');
    }

    public function show(Batch $batch)
    {
        $batch->load('product');
        return view('admin.batches.show', compact('batch'));
    }

    public function edit(Batch $batch)
    {
        $medicines = Product::all();
        return view('admin.batches.edit', compact('batch', 'medicines'));
    }

    public function update(UpdateBatchRequest $request, Batch $batch)
    {
        $batch->update($request->validated());
        return redirect()->route('admin.batches.index')->with('success', 'Batch updated successfully.');
    }

    public function destroy(Batch $batch)
    {
        $batch->delete();
        return redirect()->route('admin.batches.index')->with('success', 'Batch deleted successfully.');
    }
}
