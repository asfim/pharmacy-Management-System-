@extends('admin.layouts.app')
@php $header = 'Roles & Permissions'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Roles & Permissions</h2>
        <p class="text-sm text-slate-500 mt-1">Manage user access levels & module permissions</p>
    </div>
    <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
        <i class="fas fa-plus"></i> Add New Role
    </a>
</div>

@include('admin.layouts.alerts')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4">Role Name</th>
                    <th class="px-5 py-4">Assigned Permissions</th>
                    <th class="px-5 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($roles as $r)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 font-semibold text-slate-800 capitalize flex items-center gap-2">
                        <i class="fas fa-user-shield text-teal-600"></i>
                        <span>{{ $r->name }}</span>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex flex-wrap gap-1 max-w-2xl">
                            @forelse($r->permissions as $perm)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-mono bg-slate-100 text-slate-700">
                                {{ $perm->name }}
                            </span>
                            @empty
                            <span class="text-xs text-slate-400">No specific permissions assigned</span>
                            @endforelse
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <div class="flex justify-end gap-1">
                            <a href="{{ route('admin.roles.edit', $r) }}" class="p-2 text-teal-600 bg-teal-50 hover:bg-teal-100 rounded-lg transition" title="Edit Role & Permissions">
                                <i class="fas fa-pen-to-square text-xs"></i>
                            </a>
                            @if($r->name !== 'Super Admin')
                            <form action="{{ route('admin.roles.destroy', $r) }}" method="POST" onsubmit="return confirm('Delete this role?')">
                                @csrf
                                @method('DELETE')
                                <button class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition" title="Delete">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-5 py-12 text-center text-slate-400">
                        <i class="fas fa-shield-halved text-3xl mb-2 block"></i>
                        No roles defined yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($roles->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $roles->links() }}</div>
    @endif
</div>
@endsection
