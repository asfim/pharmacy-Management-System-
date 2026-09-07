@extends('admin.layouts.app')
@php $header = 'Prescriptions'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Prescriptions</h2>
        <p class="text-sm text-slate-500 mt-1">Uploaded and recorded patient prescriptions</p>
    </div>
</div>

@include('admin.layouts.alerts')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4">ID</th>
                    <th class="px-5 py-4">Customer</th>
                    <th class="px-5 py-4">Doctor</th>
                    <th class="px-5 py-4">Date</th>
                    <th class="px-5 py-4">Status</th>
                    <th class="px-5 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($prescriptions as $p)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 font-mono text-slate-600">#{{ $p->id }}</td>
                    <td class="px-5 py-3.5 font-semibold text-slate-800">{{ $p->customer->name ?? 'Walk-in' }}</td>
                    <td class="px-5 py-3.5 text-slate-600">{{ $p->doctor->name ?? 'N/A' }}</td>
                    <td class="px-5 py-3.5 text-slate-500 text-xs">{{ $p->created_at->format('d M Y h:i A') }}</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 capitalize">
                            {{ $p->status ?? 'pending' }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <form action="{{ route('admin.prescriptions.destroy', $p) }}" method="POST" onsubmit="return confirm('Delete this prescription?')">
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
                        <i class="fas fa-file-prescription text-3xl mb-2 block"></i>
                        No prescriptions uploaded yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($prescriptions->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $prescriptions->links() }}</div>
    @endif
</div>
@endsection
