@extends('layouts.app')

@section('title', 'Add New Product')

@section('content')
    <div class="max-w-3xl mx-auto py-10 px-6 sm:px-8">
        <div class="bg-white dark:bg-gray-900 shadow-lg rounded-2xl border border-gray-200 dark:border-gray-800">
            <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Add New Product</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Enter product details to list a new item.</p>
            </div>
            <div class="p-6">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Product Name</label>
                        <input type="text" name="name" id="name" required class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Description</label>
                        <textarea name="description" id="description" rows="4" required class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="price" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Price</label>
                            <div class="mt-2 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
                                </div>
                                <input type="number" name="price" id="price" step="0.01" min="0" required class="pl-7 pr-3 py-2 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div>
                            <label for="stock" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Stock Quantity</label>
                            <input type="number" name="stock" id="stock" min="0" required class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="image" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Product Image</label>
                        <input type="file" name="image" id="image" class="mt-2 block w-full text-sm text-gray-700 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 focus:outline-none dark:file:bg-gray-700 dark:file:text-white dark:hover:file:bg-gray-600">
                    </div>

                    <div class="flex justify-end space-x-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-md border border-gray-300 text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-800 transition">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                            Save Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
