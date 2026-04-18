@extends('layouts.app')

@section('title', 'Order Confirmed - Simple Store')

@section('content')
<div class="space-y-6 max-w-2xl mx-auto">

    {{-- Success Message --}}
    <div class="text-center py-8">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Order Confirmed!</h1>
        <p class="text-sm text-gray-400 mt-2">Thank you for your purchase. Your order has been placed successfully.</p>
        <p class="text-sm text-gray-500 mt-1">Order <span class="font-semibold text-gray-700">#{{ $order->id }}</span></p>
    </div>

    {{-- Order Items --}}
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-700">Items Ordered</h2>
        </div>
        @foreach($order->orderItems as $item)
            <div class="flex items-center gap-4 px-5 py-4 border-b border-gray-50 last:border-0">
                <div class="w-12 h-12 rounded-lg bg-gray-50 overflow-hidden flex-shrink-0">
                    @if($item->product->image)
                        <img src="{{ asset('storage/' . $item->product->image) }}"
                             alt="{{ $item->product->name }}"
                             class="w-full h-full object-cover"/>
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 21l3.75-3.75M16.5 3.75a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $item->product->name }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">₱{{ number_format($item->price, 2) }} × {{ $item->quantity }}</p>
                </div>
                <p class="text-sm font-bold text-gray-900">
                    ₱{{ number_format($item->price * $item->quantity, 2) }}
                </p>
            </div>
        @endforeach
        <div class="px-5 py-4 bg-gray-50 flex justify-between items-center">
            <span class="text-sm font-semibold text-gray-700">Total</span>
            <span class="text-base font-bold text-gray-900">₱{{ number_format($order->total_amount, 2) }}</span>
        </div>
    </div>

    {{-- Delivery Info --}}
    <div class="bg-white rounded-xl border border-gray-100 p-5 space-y-2">
        <h2 class="text-sm font-semibold text-gray-700 mb-3">Delivery Information</h2>
        <div class="space-y-2 text-sm text-gray-600">
            <p><span class="text-gray-400">Name:</span> {{ $order->name }}</p>
            <p><span class="text-gray-400">Email:</span> {{ $order->email }}</p>
            <p><span class="text-gray-400">Phone:</span> {{ $order->phone }}</p>
            <p><span class="text-gray-400">Address:</span> {{ $order->address }}</p>
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex gap-3">
        <a href="{{ route('orders.show', $order) }}"
           class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg text-sm font-medium transition-colors">
            View Order Details
        </a>
        <a href="{{ route('products.index') }}"
           class="flex-1 text-center border border-gray-200 hover:bg-gray-50 text-gray-600 py-2.5 rounded-lg text-sm font-medium transition-colors">
            Continue Shopping
        </a>
    </div>

</div>
@endsection