@extends('layouts.app')

@section('content')


    @can('updateStatus', $order)
        <div class="px-4 py-5 sm:px-6">
            <h4 class="text-md font-medium text-gray-900">Update Order Status</h4>
        </div>
        <div class="px-4 py-5 sm:p-6 border-t border-gray-200">
            <form action="{{ route('orders.updateStatus', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="flex items-center space-x-4">
                    <select name="status"
                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing
                        </option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    @endcan

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Order #{{ $order->id }}</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Placed
                on {{ $order->created_at->format('F j, Y \a\t g:i a') }}</p>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
            <dl class="sm:divide-y sm:divide-gray-200">
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                        @elseif($order->status === 'shipped') bg-green-100 text-green-800
                        @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                    </dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Total</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        ${{ number_format($order->total, 2) }}</dd>
                </div>
            </dl>
        </div>

        <div class="px-4 py-5 sm:px-6">
            <h4 class="text-md font-medium text-gray-900">Order Items</h4>
        </div>
        <div class="border-t border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-1 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product
                    </th>
                    <th scope="col"
                        class="px-1 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price
                    </th>
                    <th scope="col"
                        class="px-1 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity
                    </th>
                    <th scope="col"
                        class="px-1 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($order->items as $item)
                    <tr>
                        <td class="px-1 sm:px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                        </td>
                        <td class="px-1 sm:px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">${{ number_format($item->price, 2) }}</div>
                        </td>
                        <td class="px-1 sm:px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $item->quantity }}</div>
                        </td>
                        <td class="px-1 sm:px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                ${{ number_format($item->price * $item->quantity, 2) }}</div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="3" class="px-1 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900">
                        Order Total
                    </td>
                    <td class="px-1 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        ${{ number_format($order->total, 2) }}</td>
                </tr>
                </tfoot>
            </table>
        </div>
        @if(auth()->user()->isCustomer())
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <a href="{{ route('orders.index') }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Back to Orders
                </a>
                @if($order->canBeCancelled())
                    <form action="{{ route('orders.cancel', $order) }}" method="POST" class="inline-flex ml-2">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700">
                            Cancel Order
                        </button>
                    </form>
                @endif
            </div>
        @endif
    </div>
@endsection



