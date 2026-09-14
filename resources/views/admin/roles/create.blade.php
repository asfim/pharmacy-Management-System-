@extends('admin.layouts.app')
@php $header = 'Create Role & Assign Permissions'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Create New Role</h2>
        <p class="text-sm text-slate-500 mt-1">Set role name and select view, create, edit, delete permissions</p>
    </div>
    <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center gap-2 border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm font-medium px-4 py-2 rounded-xl transition">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="bg-white rounded-2xl border-2 border-slate-200 shadow-md hover:shadow-xl transition-shadow max-w-5xl">
    <form action="{{ route('admin.roles.store') }}" method="POST" class="p-6 space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Role Name *</label>
            <input type="text" name="name" required placeholder="e.g. Senior Pharmacist / Branch Manager" class="w-full max-w-md px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            @error('name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <div class="flex justify-between items-center mb-3">
                <label class="block text-sm font-semibold text-slate-700">Module Permissions (View, Create, Edit, Delete)</label>
                <button type="button" onclick="toggleAllPermissions(this)" class="text-xs font-semibold text-teal-600 hover:underline">
                    Select All / Deselect All
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @php
                    $groupedPermissions = $permissions->groupBy(function($perm) {
                        $parts = explode(' ', $perm->name, 2);
                        return isset($parts[1]) ? ucwords(str_replace('_', ' ', $parts[1])) : 'General';
                    });
                @endphp

                @foreach($groupedPermissions as $moduleName => $perms)
                <div class="p-4 border border-slate-200 rounded-xl bg-slate-50/50 hover:bg-white hover:shadow-sm transition">
                    <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2.5 pb-1 border-b border-slate-200 flex justify-between items-center">
                        <span><i class="fas fa-folder-open text-teal-500 mr-1.5"></i> {{ $moduleName }}</span>
                    </h4>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($perms as $p)
                        <label class="inline-flex items-center gap-2 text-xs text-slate-700 cursor-pointer hover:text-teal-700">
                            <input type="checkbox" name="permissions[]" value="{{ $p->name }}" class="perm-checkbox rounded text-teal-600 focus:ring-teal-500">
                            <span class="capitalize">{{ $p->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition shadow-sm">
                Save Role & Permissions
            </button>
        </div>
    </form>
</div>

<script>
function toggleAllPermissions(btn) {
    const checkboxes = document.querySelectorAll('.perm-checkbox');
    const anyUnchecked = Array.from(checkboxes).some(cb => !cb.checked);
    checkboxes.forEach(cb => cb.checked = anyUnchecked);
}
</script>
@endsection
