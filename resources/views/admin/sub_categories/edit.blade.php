@extends('admin.layouts.app')

@php
    $header = 'Edit subSub Category';
@endphp

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Edit subSub Category: {{ $subSub Category->name }}</h2>
            <p class="text-sm text-slate-500">Update subSub Category details</p>
        </div>
        <a href="{{ route('admin.sub-categories.index') }}" class="text-slate-500 hover:text-slate-700 font-medium py-2 px-4 rounded-lg flex items-center transition border border-slate-300 bg-white shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to List
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden max-w-3xl">
        <form action="{{ route('admin.sub-categories.update', $subSub Category) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">subSub Category Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $subSub Category->name) }}" required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 sm:text-sm text-slate-900 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Parent subSub Category -->
            <div>
                <label for="parent_subSub Category_id" class="block text-sm font-medium text-slate-700 mb-1">Parent subSub Category (Optional)</label>
                <select name="parent_subSub Category_id" id="parent_subSub Category_id" 
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 sm:text-sm text-slate-900 @error('parent_subSub Category_id') border-red-500 @enderror">
                    <option value="">-- None (Top Level) --</option>
                    @foreach($categories as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_subSub Category_id', $subSub Category->parent_subSub Category_id) == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_subSub Category_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image -->
            <div>
                <label for="image" class="block text-sm font-medium text-slate-700 mb-1">subSub Category Image</label>
                @if($subSub Category->image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/'.$subSub Category->image) }}" alt="{{ $subSub Category->name }}" class="h-20 w-20 object-cover rounded-lg border border-slate-200">
                    </div>
                @endif
                <input type="file" name="image" id="image" accept="image/*"
                    class="w-full text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                <p class="text-xs text-slate-500 mt-2">Leave blank to keep current image.</p>
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 sm:text-sm text-slate-900 @error('description') border-red-500 @enderror">{{ old('description', $subSub Category->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                <select name="status" id="status" required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 sm:text-sm text-slate-900 @error('status') border-red-500 @enderror">
                    <option value="active" {{ old('status', $subSub Category->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $subSub Category->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-medium py-2.5 px-6 rounded-lg transition shadow-sm">
                    Update subSub Category
                </button>
            </div>
        </form>
    </div>
@endsection
