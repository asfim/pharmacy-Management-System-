@extends('admin.layouts.app')

@section('title', 'Add Slider')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Add Slider ✨</h1>
        </div>
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <a href="{{ route('admin.sliders.index') }}" class="btn bg-slate-900 text-white hover:bg-slate-800">Back to List</a>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-5">
        <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium mb-1">Title</label>
                    <input type="text" name="title" class="form-input w-full" value="{{ old('title') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Highlight Title</label>
                    <input type="text" name="highlight_title" class="form-input w-full" value="{{ old('highlight_title') }}">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea name="description" rows="3" class="form-input w-full">{{ old('description') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Button Text</label>
                    <input type="text" name="button_text" class="form-input w-full" value="{{ old('button_text', 'Order Now') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Button Link</label>
                    <input type="text" name="button_link" class="form-input w-full" value="{{ old('button_link', '/products') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Status <span class="text-rose-500">*</span></label>
                    <select name="status" class="form-select w-full" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Order <span class="text-rose-500">*</span></label>
                    <input type="number" name="order" class="form-input w-full" value="{{ old('order', 1) }}" required>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-1">Image <span class="text-rose-500">*</span></label>
                    <input type="file" name="image" class="form-input w-full" accept="image/*" required>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button type="submit" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">Save Slider</button>
            </div>
        </form>
    </div>
</div>
@endsection
