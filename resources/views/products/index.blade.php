@extends('layouts.app')

@section('title', 'Products - Simple Store')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">All Products</h1>
        <span class="text-sm text-gray-400">{{ $products->total() }} items found</span>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('products.index') }}"
          class="flex flex-col sm:flex-row gap-3">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search products..."
            class="flex-1 border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
        />
        <select
            name="category"
            class="border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-gray-600"
        >
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition-colors">
            Filter
        </button>
        @if(request('search') || request('category'))
            <a href="{{ route('products.index') }}"
               class="border border-gray-200 hover:bg-gray-50 text-gray-600 px-5 py-2 rounded-lg text-sm font-medium transition-colors text-center">
                Clear
            </a>
        @endif
    </form>

    {{-- Products Grid --}}
    @if($products->isEmpty())
        <div class="text-center py-20 text-gray-400">
            <svg class="mx-auto mb-4 w-12 h-12 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
            </svg>
            <p class="text-sm">No products found.</p>
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
            @foreach($products as $product)
                <a href="{{ route('products.show', $product) }}"
                   class="group bg-white rounded-xl border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-200">
                    {{-- Product Image --}}
                    <div class="aspect-square bg-gray-50 overflow-hidden">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"/>
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 21l3.75-3.75M16.5 3.75a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Product Info --}}
                    <div class="p-3 space-y-1">
                        @if($product->category)
                            <span class="text-xs text-blue-500 font-medium">{{ $product->category->name }}</span>
                        @endif
                        <p class="text-sm font-semibold text-gray-800 leading-tight line-clamp-2 group-hover:text-blue-600 transition-colors">
                            {{ $product->name }}
                        </p>
                        <p class="text-sm font-bold text-gray-900">
                            ₱{{ number_format($product->price, 2) }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="pt-4">
                {{ $products->withQueryString()->links() }}
            </div>
        @endif
    @endif

</div>
@endsection