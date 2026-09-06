@extends('admin.layouts.app')

@php
    $header = __('Dashboard Overview');
@endphp

@section('content')
    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Sales -->
        <div class="p-6 bg-white border border-slate-200 rounded-xl shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Today's Sales</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">৳ 45,230</p>
                </div>
                <div class="p-3 bg-teal-100 rounded-lg text-teal-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="mt-4 text-sm text-green-600 font-medium">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    +12.5% from yesterday
                </span>
            </div>
        </div>

        <!-- Orders -->
        <div class="p-6 bg-white border border-slate-200 rounded-xl shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Online Orders</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">142</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
            </div>
            <div class="mt-4 text-sm text-slate-500 font-medium">
                12 pending processing
            </div>
        </div>

        <!-- Inventory -->
        <div class="p-6 bg-white border border-slate-200 rounded-xl shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Low Stock Items</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">28</p>
                </div>
                <div class="p-3 bg-red-100 rounded-lg text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>
            <div class="mt-4 text-sm text-slate-500 font-medium">
                Needs immediate reorder
            </div>
        </div>

        <!-- Prescriptions -->
        <div class="p-6 bg-white border border-slate-200 rounded-xl shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Prescriptions</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">45</p>
                </div>
                <div class="p-3 bg-indigo-100 rounded-lg text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
            <div class="mt-4 text-sm text-indigo-600 font-medium">
                8 waiting for verification
            </div>
        </div>
    </div>

    <!-- Charts and Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        <!-- Sales Chart Placeholder -->
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Revenue Overview</h3>
            <div class="h-64 flex items-center justify-center bg-slate-50 rounded-lg border border-dashed border-slate-300">
                <span class="text-slate-400 font-medium">[ Chart Component Here ]</span>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Recent Online Orders</h3>
            <div class="space-y-4">
                @for ($i = 0; $i < 4; $i++)
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                    <div>
                        <p class="font-medium text-slate-800">#ORD-{{ 9000 + $i }}</p>
                        <p class="text-sm text-slate-500">2 mins ago</p>
                    </div>
                    <span class="px-2.5 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">Pending</span>
                </div>
                @endfor
            </div>
        </div>
    </div>
@endsection
