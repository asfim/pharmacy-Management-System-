@extends('admin.layouts.app')
@php $header = 'Employees'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div><h2 class="text-2xl font-bold text-slate-800">Employees</h2><p class="text-sm text-slate-500">Manage your pharmacy staff</p></div>
    <a href="{{ route('admin.employees.create') }}" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
        <i class="fas fa-user-plus"></i> Add Employee
    </a>
</div>
@include('admin.layouts.alerts')
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4 text-left">#</th>
                    <th class="px-5 py-4 text-left">Name</th>
                    <th class="px-5 py-4 text-left">Role</th>
                    <th class="px-5 py-4 text-left">Phone</th>
                    <th class="px-5 py-4 text-left">Joining Date</th>
                    <th class="px-5 py-4 text-right">Salary</th>
                    <th class="px-5 py-4 text-center">Status</th>
                    <th class="px-5 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($employees as $emp)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 text-slate-400">{{ $loop->iteration }}</td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-teal-600 rounded-full flex items-center justify-center shrink-0">
                                <span class="text-white text-sm font-bold">{{ strtoupper(substr($emp->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800">{{ $emp->name }}</p>
                                <p class="text-xs text-slate-400">{{ $emp->email ?? '' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3.5"><span class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">{{ $emp->role }}</span></td>
                    <td class="px-5 py-3.5 text-slate-600">{{ $emp->phone }}</td>
                    <td class="px-5 py-3.5 text-slate-500">{{ \Carbon\Carbon::parse($emp->joining_date)->format('d M Y') }}</td>
                    <td class="px-5 py-3.5 text-right font-semibold text-slate-800">৳{{ number_format($emp->salary, 0) }}</td>
                    <td class="px-5 py-3.5 text-center">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $emp->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($emp->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <div class="flex justify-end gap-1">
                            <a href="{{ route('admin.employees.edit', $emp) }}" class="p-2 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg"><i class="fas fa-pen text-xs"></i></a>
                            <form action="{{ route('admin.employees.destroy', $emp) }}" method="POST" onsubmit="return confirm('Delete employee?')">
                                @csrf @method('DELETE')
                                <button class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg"><i class="fas fa-trash text-xs"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-5 py-10 text-center text-slate-400">No employees found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($employees->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $employees->links() }}</div>
    @endif
</div>
@endsection
