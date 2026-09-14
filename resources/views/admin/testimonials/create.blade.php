@extends('admin.layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Add Testimonial</h2>
        <p class="text-slate-500 text-sm">Create a new customer review</p>
    </div>
    <a href="{{ route('admin.testimonials.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 transition font-medium text-sm flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Back
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
    <form action="{{ route('admin.testimonials.store') }}" method="POST">
        @csrf

        <div class="space-y-5">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Customer Name *</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50" required placeholder="e.g. Rahim Ahmed">
                @error('title') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Review Text *</label>
                <textarea name="description" rows="3" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50" required placeholder="Write the customer's review here...">{{ old('description') }}</textarea>
                @error('description') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Rating (1-5) *</label>
                    <input type="number" name="icon" value="{{ old('icon', 5) }}" min="1" max="5" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50" required>
                    @error('icon') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Color *</label>
                    <select name="color" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50" required>
                        <option value="emerald" {{ old('color') == 'emerald' ? 'selected' : '' }}>Emerald</option>
                        <option value="blue" {{ old('color') == 'blue' ? 'selected' : '' }}>Blue</option>
                        <option value="rose" {{ old('color') == 'rose' ? 'selected' : '' }}>Rose</option>
                        <option value="amber" {{ old('color') == 'amber' ? 'selected' : '' }}>Amber</option>
                        <option value="violet" {{ old('color') == 'violet' ? 'selected' : '' }}>Violet</option>
                        <option value="teal" {{ old('color') == 'teal' ? 'selected' : '' }}>Teal</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Order *</label>
                    <input type="number" name="order" value="{{ old('order', 0) }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50" required>
                    @error('order') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Status *</label>
                <select name="status" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50" required>
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <div class="mt-8 pt-5 border-t border-slate-100 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-teal-600 text-white font-bold rounded-xl hover:bg-teal-700 transition shadow-sm shadow-teal-500/30">
                Save Testimonial
            </button>
        </div>
    </form>
</div>
@endsection
