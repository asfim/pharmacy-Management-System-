@extends('admin.layouts.app')
@php $header = 'Expense Categories'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Expense Categories</h2>
        <p class="text-sm text-slate-500 mt-1">Manage categories for your expenses</p>
    </div>
</div>

@include('admin.layouts.alerts')

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-1">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-4">Add Category</h3>
            <form action="{{ route('admin.expense-categories.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Category Name *</label>
                    <input type="text" name="name" required placeholder="e.g. Utility Bills, Salary" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                </div>
                <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm px-4 py-2.5 rounded-xl transition shadow-sm">Save Category</button>
            </form>
        </div>
    </div>
    
    <div class="md:col-span-2">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                    <tr>
                        <th class="px-5 py-4">Name</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($categories as $category)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-5 py-3.5 font-semibold text-slate-800">{{ $category->name }}</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 capitalize">
                                {{ $category->status }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <form action="{{ route('admin.expense-categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Delete this category?')">
                                @csrf @method('DELETE')
                                <button class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition" title="Delete">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-5 py-12 text-center text-slate-400">
                            <i class="fas fa-tags text-3xl mb-2 block"></i>
                            No expense categories found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            @if($categories->hasPages())
            <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $categories->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
