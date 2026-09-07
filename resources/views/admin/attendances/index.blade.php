@extends('admin.layouts.app')
@php $header = 'Employee Attendance'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Employee Attendance</h2>
        <p class="text-sm text-slate-500 mt-1">Daily clock-in & attendance logs</p>
    </div>
</div>

@include('admin.layouts.alerts')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4">Employee</th>
                    <th class="px-5 py-4">Date</th>
                    <th class="px-5 py-4">In Time</th>
                    <th class="px-5 py-4">Out Time</th>
                    <th class="px-5 py-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($attendances as $att)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 font-semibold text-slate-800">{{ $att->employee->name ?? 'Staff' }}</td>
                    <td class="px-5 py-3.5 text-slate-600">{{ $att->date ?? $att->created_at->format('Y-m-d') }}</td>
                    <td class="px-5 py-3.5 text-slate-600 font-mono text-xs">{{ $att->in_time ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-slate-600 font-mono text-xs">{{ $att->out_time ?? '-' }}</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 capitalize">
                            {{ $att->status ?? 'present' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-12 text-center text-slate-400">
                        <i class="fas fa-calendar-check text-3xl mb-2 block"></i>
                        No attendance records recorded yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($attendances, 'hasPages') && $attendances->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $attendances->links() }}</div>
    @endif
</div>
@endsection
