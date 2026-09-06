@extends('admin.layouts.app')
@php $header = 'Edit Brand'; @endphp
@section('content')
<div class="mb-6 flex justify-between items-center">
    <div><h2 class="text-2xl font-bold text-slate-800">Edit Brand: {{ $brand->name }}</h2></div>
    <a href="{{ route('admin.brands.index') }}" class="text-slate-500 hover:text-slate-700 font-medium py-2 px-4 rounded-lg flex items-center transition border border-slate-300 bg-white shadow-sm">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>Back
    </a>
</div>
<div class="bg-white rounded-xl border border-slate-200 shadow-sm max-w-2xl">
    <form action="{{ route('admin.brands.update', $brand) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-5">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Brand Name *</label>
                <input type="text" name="name" value="{{ old('name', $brand->name) }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-sm @error('name') border-red-500 @enderror">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Country</label>
                <input type="text" name="country" value="{{ old('country', $brand->country) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Contact</label>
                <input type="text" name="contact" value="{{ old('contact', $brand->contact) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Website</label>
                <input type="url" name="website" value="{{ old('website', $brand->website) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-sm">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Logo</label>
            @if($brand->logo)
                <div class="mb-3"><img src="{{ asset('storage/'.$brand->logo) }}" alt="{{ $brand->name }}" class="h-16 w-16 object-cover rounded-lg border border-slate-200"></div>
            @endif
            <input type="file" name="logo" accept="image/*" class="w-full text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
            <textarea name="description" rows="3" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-sm">{{ old('description', $brand->description ?? '') }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
            <select name="status" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-sm">
                <option value="active" {{ old('status',$brand->status)==='active'?'selected':'' }}>Active</option>
                <option value="inactive" {{ old('status',$brand->status)==='inactive'?'selected':'' }}>Inactive</option>
            </select>
        </div>
        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-medium py-2.5 px-6 rounded-lg transition shadow-sm">Update Brand</button>
        </div>
    </form>
</div>
@endsection
