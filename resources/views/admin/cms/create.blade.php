@extends('admin.layouts.app')
@php $header = 'Homepage Features'; @endphp
@section('title', 'Add Feature')
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Add Feature</h2>
        <p class="text-sm text-slate-500 mt-1">Create a new feature box for the homepage.</p>
    </div>
    <a href="{{ route('admin.cms.index') }}" class="btn bg-slate-900 text-white hover:bg-slate-800 rounded-xl px-4 py-2">
        <i class="fas fa-arrow-left mr-2"></i>Back to List
    </a>
</div>

@include('admin.layouts.alerts')

<div class="bg-white rounded-2xl border-2 border-slate-200 shadow-md hover:shadow-xl transition-shadow max-w-3xl p-8">
    <form action="{{ route('admin.cms.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="border-b border-slate-100 pb-4 mb-6">
            <h3 class="text-lg font-bold text-slate-800 mb-1"><i class="fas fa-layer-group text-teal-500 mr-2"></i> Feature Details</h3>
            <p class="text-xs text-slate-500">The title, description, and visual styling for this feature.</p>
        </div>

        <div class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Section <span class="text-rose-500">*</span></label>
                    <select name="section" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50" required>
                        <option value="feature_strip" {{ old('section') == 'feature_strip' ? 'selected' : '' }}>Feature Strip (4 Boxes below Hero)</option>
                        <option value="why_choose_us" {{ old('section') == 'why_choose_us' ? 'selected' : '' }}>Why Choose Us (List with icons)</option>
                        <option value="why_choose_stats" {{ old('section') == 'why_choose_stats' ? 'selected' : '' }}>Why Choose Us Stats (Right side 4 boxes)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Title <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50" required placeholder="e.g. Genuine Medicines">
                    @error('title') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Color Theme <span class="text-rose-500">*</span></label>
                    <select name="color" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50" required>
                        <option value="emerald" {{ old('color') == 'emerald' ? 'selected' : '' }}>Emerald (Green)</option>
                        <option value="blue" {{ old('color') == 'blue' ? 'selected' : '' }}>Blue</option>
                        <option value="violet" {{ old('color') == 'violet' ? 'selected' : '' }}>Violet (Purple)</option>
                        <option value="amber" {{ old('color') == 'amber' ? 'selected' : '' }}>Amber (Yellow)</option>
                        <option value="rose" {{ old('color') == 'rose' ? 'selected' : '' }}>Rose (Red)</option>
                        <option value="teal" {{ old('color') == 'teal' ? 'selected' : '' }}>Teal</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                <input type="text" name="description" value="{{ old('description') }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50" placeholder="e.g. 100% authentic products">
            </div>
            
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Icon (SVG Code)</label>
                <textarea name="icon" rows="3" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50 font-mono text-xs" placeholder="<svg>...</svg>">{{ old('icon') }}</textarea>
                <p class="text-xs text-slate-400 mt-2">Paste raw SVG code here. You can get free icons from heroicons.com.</p>
            </div>
        </div>

        <div class="border-t border-slate-100 pt-8 mb-6 mt-8">
            <h3 class="text-lg font-bold text-slate-800 mb-1"><i class="fas fa-toggle-on text-teal-500 mr-2"></i> Settings</h3>
            <p class="text-xs text-slate-500">Status and display order.</p>
        </div>

        <div class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Status <span class="text-rose-500">*</span></label>
                    <select name="status" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Display Order <span class="text-rose-500">*</span></label>
                    <input type="number" name="order" value="{{ old('order', 0) }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50" required>
                </div>
            </div>
        </div>

        <div class="border-t border-slate-100 pt-6 mt-8 flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-xl shadow-sm hover:shadow-md transition-all text-sm">
                <i class="fas fa-save"></i>
                Save Feature
            </button>
        </div>
    </form>
</div>
@endsection
