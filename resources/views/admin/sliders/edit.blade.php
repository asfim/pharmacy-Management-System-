@extends('admin.layouts.app')
@php $header = 'Hero Section'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Hero Section Settings</h2>
        <p class="text-sm text-slate-500 mt-1">Manage your homepage hero banner content and image.</p>
    </div>
</div>

@include('admin.layouts.alerts')

<div class="bg-white rounded-2xl border-2 border-slate-200 shadow-md hover:shadow-xl transition-shadow max-w-3xl p-8">
    <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" value="active">
        <input type="hidden" name="order" value="1">

        {{-- Section: Text Content --}}
        <div class="border-b border-slate-100 pb-4 mb-6">
            <h3 class="text-lg font-bold text-slate-800 mb-1"><i class="fas fa-heading text-teal-500 mr-2"></i> Text Content</h3>
            <p class="text-xs text-slate-500">Set the main title, highlighted text, and description for the hero banner.</p>
        </div>

        <div class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Title</label>
                    <input type="text" name="title" value="{{ old('title', $slider->title) }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50" placeholder="e.g. Your Health,">
                    @error('title') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Highlight Title</label>
                    <input type="text" name="highlight_title" value="{{ old('highlight_title', $slider->highlight_title) }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50" placeholder="e.g. Delivered Fast!">
                    @error('highlight_title') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                <textarea name="description" rows="3" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50" placeholder="Hero section description text">{{ old('description', $slider->description) }}</textarea>
                @error('description') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Section: Button --}}
        <div class="border-t border-slate-100 pt-8 mb-6 mt-8">
            <h3 class="text-lg font-bold text-slate-800 mb-1"><i class="fas fa-mouse-pointer text-teal-500 mr-2"></i> Call to Action Button</h3>
            <p class="text-xs text-slate-500">Configure the CTA button text and link.</p>
        </div>

        <div class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Button Text</label>
                    <input type="text" name="button_text" value="{{ old('button_text', $slider->button_text) }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50" placeholder="e.g. Order Now">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Button Link</label>
                    <input type="text" name="button_link" value="{{ old('button_link', $slider->button_link) }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50" placeholder="e.g. /products">
                </div>
            </div>
        </div>

        {{-- Section: Hero Image --}}
        <div class="border-t border-slate-100 pt-8 mb-6 mt-8">
            <h3 class="text-lg font-bold text-slate-800 mb-1"><i class="fas fa-image text-teal-500 mr-2"></i> Hero Image</h3>
            <p class="text-xs text-slate-500">Upload the image that appears on the right side of the hero section.</p>
        </div>

        <div class="space-y-5">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Image</label>
                <div class="flex items-center gap-6 p-4 border border-slate-200 rounded-xl bg-slate-50">
                    <div class="shrink-0" id="imagePreviewContainer">
                        @if($slider->image)
                            @php
                                $imgSrc = str_starts_with($slider->image, 'assets/')
                                    ? asset($slider->image)
                                    : asset('storage/' . $slider->image);
                            @endphp
                            <img src="{{ $imgSrc }}" id="currentImage" class="h-24 w-36 object-cover bg-white p-1 rounded-lg shadow-sm border border-slate-100" alt="Hero Image">
                        @else
                            <div id="currentImage" class="h-24 w-36 bg-slate-200 rounded-lg flex items-center justify-center text-xs text-slate-400 font-bold">No Image</div>
                        @endif
                    </div>
                    <div class="w-full">
                        <input type="file" name="image" id="imageInput" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 cursor-pointer transition">
                        <p class="text-xs text-slate-400 mt-2">Recommended: 800x600px or larger. JPG, PNG, WebP accepted.</p>
                        @error('image') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="border-t border-slate-100 pt-6 mt-8 flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-xl shadow-sm hover:shadow-md transition-all text-sm">
                <i class="fas fa-save"></i>
                Save Changes
            </button>
        </div>
    </form>
</div>

{{-- Live Image Preview Script --}}
<script>
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const container = document.getElementById('imagePreviewContainer');
                container.innerHTML = '<img src="' + event.target.result + '" id="currentImage" class="h-24 w-36 object-cover bg-white p-1 rounded-lg shadow-sm border border-slate-100" alt="New Image Preview">';
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
