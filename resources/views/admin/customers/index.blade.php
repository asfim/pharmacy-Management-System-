@extends('admin.layouts.app')
@php $header = 'Customers'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div><h2 class="text-2xl font-bold text-slate-800">Customers</h2><p class="text-sm text-slate-500">Manage customer profiles and dues</p></div>
    <a href="{{ route('admin.customers.create') }}" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
        <i class="fas fa-user-plus"></i> Add Customer
    </a>
</div>
@include('admin.layouts.alerts')
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-slate-100 flex gap-3">
        <input type="text" id="customerSearch" placeholder="Search customers..." class="flex-1 px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4 text-left">#</th>
                    <th class="px-5 py-4 text-left">Name</th>
                    <th class="px-5 py-4 text-left">Phone</th>
                    <th class="px-5 py-4 text-left">Type</th>
                    <th class="px-5 py-4 text-right">Due Balance</th>
                    <th class="px-5 py-4 text-center">Status</th>
                    <th class="px-5 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($customers as $c)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 text-slate-400">{{ $loop->iteration }}</td>
                    <td class="px-5 py-3.5">
                        <p class="font-semibold text-slate-800">{{ $c->name }}</p>
                        <p class="text-xs text-slate-400">{{ $c->email ?? '' }}</p>
                    </td>
                    <td class="px-5 py-3.5 text-slate-600">{{ $c->phone }}</td>
                    <td class="px-5 py-3.5">
                        <span class="px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-600">{{ $c->customer_type ?? 'Regular' }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-right font-semibold {{ ($c->opening_balance ?? 0) > 0 ? 'text-red-600' : 'text-slate-400' }}">
                        ৳{{ number_format(abs($c->opening_balance ?? 0), 2) }}
                    </td>
                    <td class="px-5 py-3.5 text-center">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $c->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($c->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <div class="flex justify-end gap-1">
                            <a href="{{ route('admin.customers.show', $c) }}" class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg" title="View"><i class="fas fa-eye text-xs"></i></a>
                            <a href="{{ route('admin.customers.ledger', $c) }}" class="p-2 text-purple-600 bg-purple-50 hover:bg-purple-100 rounded-lg" title="Ledger"><i class="fas fa-book text-xs"></i></a>
                            <a href="{{ route('admin.customers.edit', $c) }}" class="p-2 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg" title="Edit"><i class="fas fa-pen text-xs"></i></a>
                            <form action="{{ route('admin.customers.destroy', $c) }}" method="POST" onsubmit="return confirm('Delete customer?')">
                                @csrf @method('DELETE')
                                <button class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg"><i class="fas fa-trash text-xs"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-10 text-center text-slate-400">No customers found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($customers->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $customers->links() }}</div>
    @endif
</div>
@endsection
