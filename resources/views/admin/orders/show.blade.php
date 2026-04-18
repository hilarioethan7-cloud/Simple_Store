@extends('layouts.admin')

@section('title', 'Order #' . $order->id)

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Order #{{ $order->id }}</h2>
        <a href="{{ route('admin.orders.index') }}"
           class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
            Back to Orders
        </a>
    </div>

    <div class="grid grid-cols-2 gap-6 mb-6">
        <!-- Customer Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold text-gray-700 mb-4">Customer Information</h3>
            <p><span class="text-gray-500">Name:</span> {{ $order->name }}</p>
            <p><span class="text-gray-500">Email:</span> {{ $order->email }}</p>
            <p><span class="text-gray-500">Phone:</span> {{ $order->phone }}</p>
            <p><span class="text-gray-500">Address:</span> {{ $order->address }}</p>
        </div>

        <!-- Update Status -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold text-gray-700 mb-4">Update Status</h3>
            <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                <select name="status"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                        <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
                <button type="submit"
                        class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Update Status
                </button>
            </form>
        </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b">
            <h3 class="font-semibold text-gray-700">Order Items</h3>
        </div>
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Product</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Price</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Quantity</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($order->orderItems as $item)
                    <tr>
                        <td class="px-6 py-4">{{ $item->product->name }}</td>
                        <td class="px-6 py-4">${{ number_format($item->price, 2) }}</td>
                        <td class="px-6 py-4">{{ $item->quantity }}</td>
                        <td class="px-6 py-4">${{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <td colspan="3" class="px-6 py-4 text-right font-semibold">Total:</td>
                    <td class="px-6 py-4 font-bold">${{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection