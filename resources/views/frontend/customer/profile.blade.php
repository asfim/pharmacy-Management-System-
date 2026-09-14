@extends('frontend.layouts.customer')

@section('content')
<div class="cd-card max-w-2xl">
    <div class="cd-card-header">
        <h3 class="cd-card-title flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            My Profile
        </h3>
    </div>

    <form action="#" method="POST" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
                <input type="text" name="name" value="{{ $user->name }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-primary focus:border-primary outline-none transition-colors" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                <input type="email" name="email" value="{{ $user->email }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg bg-slate-50 text-slate-500 cursor-not-allowed" readonly>
                <p class="text-xs text-slate-500 mt-1">Email cannot be changed.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Phone Number</label>
                <input type="text" name="phone" value="{{ $customer->phone ?? '' }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-primary focus:border-primary outline-none transition-colors" placeholder="e.g. 017xxxxxxxx">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Date of Birth</label>
                <input type="date" name="dob" value="{{ $customer->dob ?? '' }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-primary focus:border-primary outline-none transition-colors">
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end">
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg font-semibold hover:bg-emerald-600 transition-colors">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
