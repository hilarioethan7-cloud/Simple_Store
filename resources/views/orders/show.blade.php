@extends('app')

@section('title', $order->orderItems->first()->product->name . ' - Simple Store')

@section('content')
@php $product = $order->orderItems->first()->product; @endphp
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-400">
        <a href="{{ route('products.index') }}" class="hover:text-gray-600">Products</a>
        <span>/</span>
        <span class="text-gray-600">{{ $product->name }}</span>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 p-6 grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- Product Image --}}
        <div class="h-72 rounded-lg overflow-hidden bg-gray-50">
            @if(!empty($product->image))
                <img src="{{ asset('storage/' . $product->image) }}"
                     alt="{{ $product->name }}"
                     class="h-full w-full object-cover">
            @else
                <img src="https://placehold.co/600x400?text={{ urlencode($product->name) }}"
                     alt="{{ $product->name }}"
                     class="h-full w-full object-cover">
            @endif
        </div>

        {{-- Product Details --}}
        <div class="space-y-4">
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide">
                    {{ $product->category->name ?? 'Uncategorized' }}
                </p>
                <h1 class="text-2xl font-bold text-gray-800 mt-1">{{ $product->name }}</h1>
            </div>

            <p class="text-2xl font-semibold text-blue-600">
                ₱{{ number_format($product->price, 2) }}
            </p>

            <p class="text-sm text-gray-500 leading-relaxed">
                {{ $product->description ?? 'No description available.' }}
            </p>

            <p class="text-sm text-gray-400">
                Stock: <span class="font-medium text-gray-700">{{ $product->stock ?? 0 }}</span>
            </p>

            {{-- Order Info --}}
            <div class="border-t border-gray-100 pt-4 space-y-1">
                <p class="text-sm text-gray-400">
                    Order: <span class="font-medium text-gray-700">#{{ $order->id }}</span>
                </p>
                <p class="text-sm text-gray-400">
                    Quantity: <span class="font-medium text-gray-700">{{ $order->orderItems->first()->quantity }}</span>
                </p>
                <p class="text-sm text-gray-400">
                    Date: <span class="font-medium text-gray-700">{{ $order->created_at->format('M d, Y') }}</span>
                </p>
                <p class="text-sm text-gray-400">
                    Total: <span class="font-medium text-blue-600">₱{{ number_format($order->orderItems->first()->quantity * $product->price, 2) }}</span>
                </p>
            </div>

            {{-- Add to Cart --}}
            @auth
                <form action="{{ route('cart.add', $product) }}" method="POST"
                      class="flex items-center gap-3 pt-2">
                    @csrf
                    <input type="number" name="quantity" value="1" min="1"
                           max="{{ $product->stock ?? 99 }}"
                           class="w-20 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                        Add to Cart
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                    Login to Add to Cart
                </a>
            @endauth

        </div>

    </div>
</div>
@endsection