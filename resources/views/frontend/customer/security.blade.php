@extends('frontend.layouts.customer')

@section('content')
<div class="cd-card max-w-2xl">
    <div class="cd-card-header">
        <h3 class="cd-card-title flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            Security & Password
        </h3>
    </div>

    <form action="#" method="POST" class="space-y-6">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Current Password</label>
                <input type="password" name="current_password" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-primary focus:border-primary outline-none transition-colors" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">New Password</label>
                <input type="password" name="password" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-primary focus:border-primary outline-none transition-colors" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-primary focus:border-primary outline-none transition-colors" required>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end">
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg font-semibold hover:bg-emerald-600 transition-colors">
                Update Password
            </button>
        </div>
    </form>
</div>
@endsection
