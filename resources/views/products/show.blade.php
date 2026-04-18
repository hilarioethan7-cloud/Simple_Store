@extends('layouts.app')

@section('title', '{{ $product->name }} - Simple Store')

@section('content')
<div class="space-y-6">

    {{-- Back --}}
    <a href="{{ route('products.index') }}"
       class="inline-flex items-center gap-1 text-sm text-gray-400 hover:text-gray-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Products
    </a>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- Product Image --}}
        <div class="aspect-square bg-gray-50 rounded-xl overflow-hidden">
            @if($product->image)
                <img src="{{ Str::startsWith($product->image, 'http') 
                        ? $product->image 
                        : asset('storage/' . $product->image) }}"
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover"/>
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-300">
                    <svg class="w-20 h-20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 21l3.75-3.75M16.5 3.75a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z"/>
                    </svg>
                </div>
            @endif
        </div>

        {{-- Product Details --}}
        <div class="space-y-4">
            @if($product->category)
                <span class="text-xs text-blue-500 font-medium">{{ $product->category->name }}</span>
            @endif

            <h1 class="text-2xl font-bold text-gray-800">{{ $product->name }}</h1>

            <p class="text-2xl font-bold text-gray-900">₱{{ number_format($product->price, 2) }}</p>

            <p class="text-sm text-gray-500 leading-relaxed">{{ $product->description }}</p>

            @if($product->stock > 0)
                <p class="text-xs text-green-600 font-medium">{{ $product->stock }} in stock</p>
            @else
                <p class="text-xs text-red-500 font-medium">Out of stock</p>
            @endif

            @auth
                @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product) }}" method="POST">
                        @csrf
                        <div class="flex items-center gap-3 mb-4">
                            <label class="text-sm text-gray-600">Quantity</label>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                   class="w-20 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                        </div>
                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl text-sm font-semibold transition-colors">
                            Add to Cart
                        </button>
                    </form>
                @else
                    <button disabled
                            class="w-full bg-gray-200 text-gray-400 py-3 rounded-xl text-sm font-semibold cursor-not-allowed">
                        Out of Stock
                    </button>
                @endif
            @else
                <a href="{{ route('login') }}"
                   class="block text-center w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl text-sm font-semibold transition-colors">
                    Login to Add to Cart
                </a>
            @endauth
        </div>

    </div>

</div>
@endsection