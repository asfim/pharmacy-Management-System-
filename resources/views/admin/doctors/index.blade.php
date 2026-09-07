@extends('admin.layouts.app')
@php $header = 'Doctors'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Doctors</h2>
        <p class="text-sm text-slate-500 mt-1">Manage prescribing doctors & medical specialists</p>
    </div>
    <a href="{{ route('admin.doctors.create') }}" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
        <i class="fas fa-user-doctor"></i> Add Doctor
    </a>
</div>

@include('admin.layouts.alerts')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4">Name</th>
                    <th class="px-5 py-4">Specialization</th>
                    <th class="px-5 py-4">BMDC No.</th>
                    <th class="px-5 py-4">Hospital / Chamber</th>
                    <th class="px-5 py-4">Phone</th>
                    <th class="px-5 py-4">Status</th>
                    <th class="px-5 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($doctors as $d)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 font-semibold text-slate-800">
                        Dr. {{ $d->name }}
                        @if($d->degree)<span class="block text-xs font-normal text-slate-400">{{ $d->degree }}</span>@endif
                    </td>
                    <td class="px-5 py-3.5 text-slate-600">{{ $d->specialization ?? 'General' }}</td>
                    <td class="px-5 py-3.5 font-mono text-xs text-slate-500">{{ $d->bmdc_no ?? 'N/A' }}</td>
                    <td class="px-5 py-3.5 text-slate-600 text-xs">{{ $d->hospital_clinic ?? $d->chamber ?? 'N/A' }}</td>
                    <td class="px-5 py-3.5 text-slate-600">{{ $d->phone ?? 'N/A' }}</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $d->status==='active' ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-600' }} capitalize">
                            {{ $d->status }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <form action="{{ route('admin.doctors.destroy', $d) }}" method="POST" onsubmit="return confirm('Delete this doctor record?')">
                            @csrf @method('DELETE')
                            <button class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition" title="Delete">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-12 text-center text-slate-400">
                        <i class="fas fa-user-doctor text-3xl mb-2 block"></i>
                        No doctors listed yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($doctors->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $doctors->links() }}</div>
    @endif
</div>
@endsection
