@extends('admin.layouts.app')
@php $header = 'Expenses'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div><h2 class="text-2xl font-bold text-slate-800">Expense Management</h2></div>
    <a href="{{ route('admin.expenses.create') }}" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
        <i class="fas fa-plus"></i> Add Expense
    </a>
</div>
@include('admin.layouts.alerts')

<!-- Stats -->
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
        <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Total Expenses</p>
        <p class="text-2xl font-bold text-slate-800">৳{{ number_format($total, 2) }}</p>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
        <p class="text-xs font-semibold text-slate-500 uppercase mb-1">This Month</p>
        <p class="text-2xl font-bold text-slate-800">৳{{ number_format(\App\Models\Expense::where('date', '>=', now()->startOfMonth())->sum('amount'), 2) }}</p>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
        <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Today</p>
        <p class="text-2xl font-bold text-slate-800">৳{{ number_format(\App\Models\Expense::whereDate('date', today())->sum('amount'), 2) }}</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4 text-left">Category</th>
                    <th class="px-5 py-4 text-left">Description</th>
                    <th class="px-5 py-4 text-left">Date</th>
                    <th class="px-5 py-4 text-left">Payment</th>
                    <th class="px-5 py-4 text-right">Amount</th>
                    <th class="px-5 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($expenses as $e)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5">
                        <span class="px-2.5 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-semibold">{{ $e->category }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-slate-600">{{ Str::limit($e->description, 40) ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-slate-500">{{ \Carbon\Carbon::parse($e->date)->format('d M Y') }}</td>
                    <td class="px-5 py-3.5 text-slate-600 capitalize">{{ $e->payment_method }}</td>
                    <td class="px-5 py-3.5 text-right font-bold text-red-600">৳{{ number_format($e->amount, 2) }}</td>
                    <td class="px-5 py-3.5 text-right">
                        <div class="flex justify-end gap-1">
                            <a href="{{ route('admin.expenses.edit', $e) }}" class="p-2 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg"><i class="fas fa-pen text-xs"></i></a>
                            <form action="{{ route('admin.expenses.destroy', $e) }}" method="POST" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg"><i class="fas fa-trash text-xs"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-5 py-10 text-center text-slate-400">No expenses found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($expenses->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $expenses->links() }}</div>
    @endif
</div>
@endsection
