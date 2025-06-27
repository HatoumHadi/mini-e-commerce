@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Our Products</h2>

            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('products.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                             fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                  clip-rule="evenodd"/>
                        </svg>
                        Add New Product
                    </a>
                @endif
            @endauth
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div
                    class="bg-white border border-gray-200 rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden flex flex-col">
                    @if($product->image)
                        <div class="h-48 overflow-hidden">
                            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @endif

                    <div class="p-7 flex flex-col flex-grow">
                        <div class="flex-grow">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $product->description }}</p>
                        </div>

                        <div class="flex justify-between items-center mb-4">
                            <span
                                class="text-blue-600 font-bold text-lg">${{ number_format($product->price, 2) }}</span>
                            <span
                                class="text-sm px-3 py-1 rounded-full {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $product->stock }} in stock
                    </span>
                        </div>

                        <div class="flex space-x-2">
                            <a href="{{ route('products.show', $product) }}"
                               class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-md transition-colors duration-200 text-sm flex items-center justify-center">
                                Details
                            </a>

                            @auth
                                @unless(auth()->user()->isAdmin())
                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit"
                                                @if($product->stock <= 0) disabled @endif
                                                class="w-full font-medium py-2 px-4 rounded-md transition-colors duration-200 text-sm flex items-center justify-center
                                               @if($product->stock <= 0)
                                                   bg-gray-400 text-gray-600 cursor-not-allowed relative group
                                               @else
                                                   bg-blue-600 hover:bg-blue-700 text-white
                                               @endif">
                                            @if($product->stock <= 0)
                                                Out of Stock
                                                <span
                                                    class="absolute hidden group-hover:block bg-gray-800 text-white text-xs rounded py-1 px-2 -bottom-7 -left-1 transform -translate-x-1/2 whitespace-nowrap">
                                                    Product is out of stock
                                                </span>
                                            @else
                                                Add to Cart
                                            @endif
                                        </button>
                                    </form>
                                @endunless
                            @endauth
                        </div>

                        @auth
                            @if(auth()->user()->isAdmin())
                                <div class="mt-4 pt-4 border-t border-gray-100 flex space-x-2">
                                    <a href="{{ route('products.edit', $product) }}"
                                       class="flex-1 text-center bg-blue-500 hover:bg-blue-400 text-white font-medium py-2 px-4 rounded-md transition-colors duration-200">
                                        Edit
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                                          class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this product?')"
                                                class="w-full bg-red-600 hover:bg-red-500 text-white font-medium py-2 px-4 rounded-md transition-colors duration-200">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>

        @if($products->hasPages())
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection
