@extends('admin.layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Testimonials</h2>
        <p class="text-slate-500 text-sm">Manage customer reviews for the homepage</p>
    </div>
    <a href="{{ route('admin.testimonials.create') }}" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition font-medium text-sm flex items-center">
        <i class="fas fa-plus mr-2"></i> Add Testimonial
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                    <th class="p-4 font-semibold">Customer Name</th>
                    <th class="p-4 font-semibold">Review</th>
                    <th class="p-4 font-semibold">Rating</th>
                    <th class="p-4 font-semibold">Color</th>
                    <th class="p-4 font-semibold">Order</th>
                    <th class="p-4 font-semibold">Status</th>
                    <th class="p-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($testimonials as $t)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="p-4 font-medium text-slate-800">{{ $t->title }}</td>
                    <td class="p-4 text-slate-500 max-w-xs truncate">{{ $t->description }}</td>
                    <td class="p-4 text-amber-500">
                        @for($i = 0; $i < $t->icon; $i++) ★ @endfor
                    </td>
                    <td class="p-4 text-slate-500 capitalize">{{ $t->color ?? 'emerald' }}</td>
                    <td class="p-4 text-slate-500">{{ $t->order }}</td>
                    <td class="p-4">
                        @if($t->status == 'active')
                            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium">Active</span>
                        @else
                            <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-medium">Inactive</span>
                        @endif
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('admin.testimonials.edit', $t) }}" class="p-2 text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.testimonials.destroy', $t) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-rose-600 bg-rose-50 rounded-lg hover:bg-rose-100 transition" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-slate-500">
                        No testimonials found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
