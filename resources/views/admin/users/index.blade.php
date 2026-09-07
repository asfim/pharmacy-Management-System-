@extends('admin.layouts.app')
@php $header = 'System Users'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">System Users</h2>
        <p class="text-sm text-slate-500 mt-1">Manage admin panel user accounts & roles</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
        <i class="fas fa-plus"></i> Add User
    </a>
</div>

@include('admin.layouts.alerts')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4">Name</th>
                    <th class="px-5 py-4">Email</th>
                    <th class="px-5 py-4">Role(s)</th>
                    <th class="px-5 py-4">Status</th>
                    <th class="px-5 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($users as $u)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 font-semibold text-slate-800">{{ $u->name }}</td>
                    <td class="px-5 py-3.5 text-slate-600 font-mono text-xs">{{ $u->email }}</td>
                    <td class="px-5 py-3.5">
                        <div class="flex flex-wrap gap-1">
                            @forelse($u->roles as $r)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-teal-50 text-teal-700 capitalize">
                                {{ $r->name }}
                            </span>
                            @empty
                            <span class="text-xs text-slate-400">No role assigned</span>
                            @endforelse
                        </div>
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ ($u->status ?? 'active')==='active' ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-600' }} capitalize">
                            {{ $u->status ?? 'active' }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        @if($u->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $u) }}" method="POST" onsubmit="return confirm('Delete this user account?')">
                            @csrf @method('DELETE')
                            <button class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition" title="Delete">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-12 text-center text-slate-400">
                        <i class="fas fa-users text-3xl mb-2 block"></i>
                        No users found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $users->links() }}</div>
    @endif
</div>
@endsection
