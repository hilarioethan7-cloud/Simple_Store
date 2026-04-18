@extends('layouts.app')

@section('title', 'Order #' . $order->id)

@section('content')
<div class="space-y-6">

    {{-- Back --}}
    <a href="{{ route('orders.index') }}"
       class="inline-flex items-center gap-1 text-sm text-gray-400 hover:text-gray-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Orders
    </a>

    <h1 class="text-2xl font-bold text-gray-800">Order #{{ $order->id }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Order Info --}}
        <div class="bg-white rounded-xl border border-gray-100 p-6 space-y-3">
            <h3 class="font-semibold text-gray-700">Order Information</h3>
            <div class="text-sm text-gray-600 space-y-2">
                <p><span class="text-gray-400">Status:</span>
                    <span class="ml-2 px-2 py-1 rounded-full text-xs font-medium
                        {{ $order->status === 'delivered' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $order->status === 'shipped' ? 'bg-purple-100 text-purple-700' : '' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
                <p><span class="text-gray-400">Date:</span> {{ $order->created_at->format('M d, Y') }}</p>
                <p><span class="text-gray-400">Total:</span> ₱{{ number_format($order->total_amount, 2) }}</p>
            </div>
        </div>

        {{-- Delivery Info --}}
        <div class="bg-white rounded-xl border border-gray-100 p-6 space-y-3">
            <h3 class="font-semibold text-gray-700">Delivery Information</h3>
            <div class="text-sm text-gray-600 space-y-2">
                <p><span class="text-gray-400">Name:</span> {{ $order->name }}</p>
                <p><span class="text-gray-400">Email:</span> {{ $order->email }}</p>
                <p><span class="text-gray-400">Phone:</span> {{ $order->phone }}</p>
                <p><span class="text-gray-400">Address:</span> {{ $order->address }}</p>
            </div>
        </div>
    </div>

    {{-- Order Items --}}
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="font-semibold text-gray-700">Order Items</h3>
        </div>
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Qty</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($order->orderItems as $item)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-800">
                            {{ $item->product->name ?? 'Product unavailable' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            ₱{{ number_format($item->price, 2) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $item->quantity }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">
                            ₱{{ number_format($item->price * $item->quantity, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <td colspan="3" class="px-6 py-4 text-right text-sm font-semibold text-gray-700">
                        Total:
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-gray-900">
                        ₱{{ number_format($order->total_amount, 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

</div>
@endsection