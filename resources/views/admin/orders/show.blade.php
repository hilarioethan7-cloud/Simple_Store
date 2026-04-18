@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6 flex gap-8">
            @if($product->image)
                <img src="{{ Storage::url($product->image) }}"
                     class="w-64 h-64 object-cover rounded-lg">
            @else
                <div class="w-64 h-64 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                    No Image
                </div>
            @endif

            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $product->name }}</h1>
                <p class="text-gray-500 mb-2">{{ $product->category->name }}</p>
                <p class="text-3xl font-bold text-blue-600 mb-4">${{ number_format($product->price, 2) }}</p>
                <p class="text-gray-600 mb-6">{{ $product->description }}</p>

                @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="flex gap-3">
                        @csrf
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                               class="w-20 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                            Add to Cart
                        </button>
                    </form>
                    <p class="text-gray-400 text-sm mt-2">{{ $product->stock }} in stock</p>
                @else
                    <p class="text-red-500 font-semibold">Out of Stock</p>
                @endif
            </div>
        </div>
    </div>
@endsection