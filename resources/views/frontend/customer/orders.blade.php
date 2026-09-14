@extends('frontend.layouts.customer')

@section('content')
<div class="cd-card">
    <div class="cd-card-header">
        <h3 class="cd-card-title flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            My Orders
        </h3>
    </div>

    @if(isset($orders) && count($orders) > 0)
        <table class="cd-orders-table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td><strong>{{ $order->order_no }}</strong></td>
                    <td>{{ $order->created_at->format('d M, Y') }}</td>
                    <td>
                        <span class="status-badge status-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td><strong>৳{{ number_format($order->total, 0) }}</strong></td>
                    <td>
                        <a href="#" class="text-primary hover:underline text-sm font-semibold">View Details</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        @if(method_exists($orders, 'links'))
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        @endif
    @else
        <div class="cd-empty">
            <div class="cd-empty-icon flex justify-center text-slate-300 mb-4">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <p>You haven't placed any orders yet. <a href="{{ route('home') }}" style="color: var(--primary)">Start shopping!</a></p>
        </div>
    @endif
</div>
@endsection
