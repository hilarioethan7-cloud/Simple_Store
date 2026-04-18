@extends('layouts.app')

@section('title', 'My Orders - Simple Store')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">My Orders</h1>
        <span class="text-sm text-gray-400">{{ $orders->total() }} orders found</span>
    </div>

    @if($orders->isEmpty())
        <div class="text-center py-20 text-gray-400">
            <p class="text-sm">You have no orders yet.</p>
            <a href="{{ route('products.index') }}"
               class="inline-block mt-4 bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                Start Shopping
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <a href="{{ route('orders.show', $order) }}"
                   class="block bg-white rounded-xl border border-gray-100 p-5 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between">
                        <div class="space-y-1">
                            <p class="text-sm font-semibold text-gray-800">Order #{{ $order->id }}</p>
                            <p class="text-xs text-gray-400">{{ $order->created_at->format('F j, Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $order->orderItems->count() }} item(s)</p>
                        </div>
                        <div class="text-right space-y-2">
                            <p class="text-sm font-bold text-gray-900">₱{{ number_format($order->total_amount, 2) }}</p>
                            <span @class([
                                'text-xs font-medium px-2 py-1 rounded-full',
                                'bg-yellow-100 text-yellow-700' => $order->status === 'pending',
                                'bg-blue-100 text-blue-700'    => $order->status === 'processing',
                                'bg-green-100 text-green-700'  => $order->status === 'completed',
                                'bg-red-100 text-red-700'      => $order->status === 'cancelled',
                            ])>
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        @if($orders->hasPages())
            <div class="pt-4">
                {{ $orders->withQueryString()->links() }}
            </div>
        @endif
    @endif

</div>
@endsection