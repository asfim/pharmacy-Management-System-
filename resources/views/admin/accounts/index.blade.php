@extends('admin.layouts.app')
@php $header = 'Accounts & Finance'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Accounts & Bank Accounts</h2>
        <p class="text-sm text-slate-500 mt-1">Manage cash accounts, bank accounts, and mobile banking</p>
    </div>
    <a href="{{ route('admin.accounts.create') }}" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
        <i class="fas fa-plus"></i> Add Account
    </a>
</div>

@include('admin.layouts.alerts')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4">Account Name</th>
                    <th class="px-5 py-4">Account No.</th>
                    <th class="px-5 py-4">Bank Name</th>
                    <th class="px-5 py-4 text-right">Opening Balance</th>
                    <th class="px-5 py-4">Status</th>
                    <th class="px-5 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($accounts as $acc)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 font-semibold text-slate-800">{{ $acc->name ?? $acc->account_name }}</td>
                    <td class="px-5 py-3.5 font-mono text-slate-600">{{ $acc->account_number ?? 'N/A' }}</td>
                    <td class="px-5 py-3.5 text-slate-600">{{ $acc->bank_name ?? 'Cash / Mobile' }}</td>
                    <td class="px-5 py-3.5 text-right font-bold text-slate-800">৳{{ number_format($acc->opening_balance ?? 0, 2) }}</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 capitalize">
                            {{ $acc->status ?? 'active' }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <form action="{{ route('admin.accounts.destroy', $acc) }}" method="POST" onsubmit="return confirm('Delete this account?')">
                            @csrf @method('DELETE')
                            <button class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition" title="Delete">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-slate-400">
                        <i class="fas fa-wallet text-3xl mb-2 block"></i>
                        No accounts setup yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($accounts->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $accounts->links() }}</div>
    @endif
</div>
@endsection
