@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Products</h2>
    </div>

    <!-- Search & Filter -->
    <form method="GET" action="{{ route('products.index') }}" class="flex gap-3 mb-6">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search products..."
               class="border border-gray-300 rounded-lg px-4 py-2 flex-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <select name="category" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            Search
        </button>
    </form>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
            <a href="{{ route('products.show', $product) }}"
               class="bg-white rounded-lg shadow hover:shadow-md transition overflow-hidden">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}"
                         class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                        No Image
                    </div>
                @endif
                <div class="p-4">
                    <h3 class="font-semibold text-gray-800">{{ $product->name }}</h3>
                    <p class="text-gray-500 text-sm">{{ $product->category->name }}</p>
                    <p class="text-blue-600 font-bold mt-1">${{ number_format($product->price, 2) }}</p>
                </div>
            </a>
        @empty
            <p class="text-gray-500 col-span-4">No products found.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $products->links() }}</div>
@endsection