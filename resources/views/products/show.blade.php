@extends('app')

@section('title', $product->name . ' - Simple Store')

@section('content')
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
                <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}"
                     alt="{{ $product->name }}"
                     class="h-full w-full object-cover"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="h-full w-full bg-gradient-to-br from-blue-50 to-gray-100 items-center justify-center" style="display:none;">
                    <span class="text-gray-400 text-lg font-medium text-center px-4">{{ $product->name }}</span>
                </div>
            @else
                <div class="h-full w-full bg-gradient-to-br from-blue-50 to-gray-100 flex items-center justify-center">
                    <span class="text-gray-400 text-lg font-medium text-center px-4">{{ $product->name }}</span>
                </div>
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

            <hr class="border-gray-100">

            <div class="text-sm text-gray-600">
                <span>Stock: </span>
                <span class="font-medium text-gray-800">{{ $product->stock }}</span>
            </div>

            {{-- Add to Cart --}}
            @auth
                <form action="{{ route('cart.add', $product) }}" method="POST"
                      x-data="{ open: false, selected: '', label: '' }">
                    @csrf
                    <input type="hidden" name="payment_method" :value="selected">

                    {{-- Payment Dropdown Toggle --}}
                    <button
                        type="button"
                        @click="open = !open"
                        class="w-full flex items-center justify-between px-3 py-2 rounded-lg border border-gray-200 text-sm text-gray-500 hover:border-blue-400 hover:text-blue-600 transition-colors">
                        <span x-text="label || 'Select Payment Method'"></span>
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    {{-- Dropdown Options --}}
                    <div x-show="open" x-transition @click.outside="open = false"
                         class="mt-1 rounded-lg border border-gray-100 shadow-md bg-white overflow-hidden z-10 relative">

                        @php
                            $methods = [
                                ['value' => 'cod',   'label' => 'Cash on Delivery',  'icon' => '🚚'],
                                ['value' => 'gcash', 'label' => 'GCash',              'icon' => '📱'],
                                ['value' => 'maya',  'label' => 'Maya',               'icon' => '💳'],
                                ['value' => 'card',  'label' => 'Credit/Debit Card',  'icon' => '🏦'],
                                ['value' => 'bank',  'label' => 'Bank Transfer',      'icon' => '🏛️'],
                            ];
                        @endphp

                        @foreach($methods as $method)
                            <button
                                type="button"
                                @click="selected = '{{ $method['value'] }}'; label = '{{ $method['icon'] }} {{ $method['label'] }}'; open = false"
                                class="w-full flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors text-left"
                                :class="selected === '{{ $method['value'] }}' ? 'bg-blue-50 text-blue-700 font-medium' : ''">
                                <span>{{ $method['icon'] }}</span>
                                <span>{{ $method['label'] }}</span>
                                <svg x-show="selected === '{{ $method['value'] }}'" class="w-4 h-4 ml-auto text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.121-4.121a1 1 0 011.414-1.414L8.414 12.172l6.879-6.879a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        @endforeach
                    </div>

                    {{-- Add to Cart Submit --}}
                    <button
                        type="submit"
                        :disabled="!selected"
                        class="mt-2 w-full py-2 rounded-lg text-sm font-semibold transition-colors"
                        :class="selected
                            ? 'bg-blue-600 text-white hover:bg-blue-700 cursor-pointer'
                            : 'bg-gray-100 text-gray-400 cursor-not-allowed'">
                        Add to Cart
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="block text-center bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                    Login to Add to Cart
                </a>
            @endauth

            <div class="pt-2">
                <a href="{{ route('products.index') }}"
                   class="inline-block border border-gray-200 text-gray-500 px-5 py-2 rounded-lg text-sm font-medium hover:border-gray-400 hover:text-gray-700 transition-colors">
                    ← Back to Products
                </a>
            </div>

        </div>
    </div>

</div>
@endsection