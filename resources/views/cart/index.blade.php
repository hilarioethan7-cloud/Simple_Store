@extends('layouts.app')

@section('title', 'Cart - Simple Store')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Your Cart</h1>
        @if(!empty($cart))
            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-sm text-red-500 hover:text-red-700 transition-colors">
                    Clear Cart
                </button>
            </form>
        @endif
    </div>

    @if(empty($cart))
        <div class="text-center py-20 text-gray-400">
            <svg class="mx-auto mb-4 w-12 h-12 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
            </svg>
            <p class="text-sm">Your cart is empty.</p>
            <a href="{{ route('products.index') }}"
               class="inline-block mt-4 bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                Browse Products
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Cart Items --}}
            <div class="md:col-span-2 space-y-3">
                @foreach($cart as $productId => $item)
                    <div class="bg-white rounded-xl border border-gray-100 p-4 flex items-center gap-4">
                        {{-- Image --}}
                        <div class="w-16 h-16 rounded-lg bg-gray-50 overflow-hidden flex-shrink-0">
                            @if($item['image'] ?? null)
                                <img src="{{ asset('storage/' . $item['image']) }}"
                                     alt="{{ $item['name'] }}"
                                     class="w-full h-full object-cover"/>
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 21l3.75-3.75M16.5 3.75a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Details --}}
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ $item['name'] }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">₱{{ number_format($item['price'], 2) }} each</p>
                        </div>

                        {{-- Quantity Update --}}
                        <form action="{{ route('cart.update', $productId) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                   class="w-16 border border-gray-200 rounded-lg px-2 py-1 text-sm text-center focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                            <button type="submit" class="text-xs text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                Update
                            </button>
                        </form>

                        {{-- Subtotal --}}
                        <p class="text-sm font-bold text-gray-900 w-20 text-right">
                            ₱{{ number_format($item['subtotal'], 2) }}
                        </p>

                        {{-- Remove --}}
                        <form action="{{ route('cart.remove', $productId) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            {{-- Order Summary --}}
            <div class="space-y-4">
                <div class="bg-white rounded-xl border border-gray-100 p-5 space-y-4">
                    <h2 class="text-sm font-semibold text-gray-700">Order Summary</h2>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Subtotal</span>
                        <span class="font-semibold text-gray-900">₱{{ number_format($total, 2) }}</span>
                    </div>
                    <div class="border-t border-gray-100 pt-4 flex justify-between">
                        <span class="text-sm font-semibold text-gray-700">Total</span>
                        <span class="text-base font-bold text-gray-900">₱{{ number_format($total, 2) }}</span>
                    </div>
                    <a href="{{ route('checkout.index') }}"
                       class="block text-center bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg text-sm font-semibold transition-colors">
                        Proceed to Checkout
                    </a>
                </div>
                <a href="{{ route('products.index') }}"
                   class="block text-center border border-gray-200 hover:bg-gray-50 text-gray-600 px-5 py-2 rounded-lg text-sm font-medium transition-colors">
                    ← Continue Shopping
                </a>
            </div>

        </div>
    @endif

</div>
@endsection