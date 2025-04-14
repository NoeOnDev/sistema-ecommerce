@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-lg p-6 text-center mb-8">
            <div class="mb-4">
                <svg class="mx-auto h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">¡Pedido Realizado con Éxito!</h1>
            <p class="text-gray-600">Tu número de pedido es: <span class="font-semibold">{{ $order->order_number }}</span>
            </p>
            <p class="text-gray-600 mt-2">Hemos enviado los detalles del pedido a tu correo electrónico.</p>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Detalles del Pedido</h2>

            <div class="border-b border-gray-200 pb-4 mb-4">
                <h3 class="font-medium text-gray-700 mb-2">Resumen:</h3>
                <div class="flex justify-between mb-1">
                    <span class="text-gray-600">Fecha:</span>
                    <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex justify-between mb-1">
                    <span class="text-gray-600">Estado:</span>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="flex justify-between mb-1">
                    <span class="text-gray-600">Pago:</span>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
                <div class="flex justify-between mb-1">
                    <span class="text-gray-600">Método de pago:</span>
                    <span>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                </div>
            </div>

            <div class="border-b border-gray-200 pb-4 mb-4">
                <h3 class="font-medium text-gray-700 mb-2">Productos:</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Producto</th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Cantidad</th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Precio</th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-normal text-sm font-medium text-gray-900">
                                    {{ $item->product_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                    {{ $item->formatted_price }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                    {{ $item->formatted_subtotal }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="border-b border-gray-200 pb-4 mb-4">
                <h3 class="font-medium text-gray-700 mb-2">Dirección de Envío:</h3>
                <address class="text-sm not-italic text-gray-600">
                    {{ $order->address->first_name }} {{ $order->address->last_name }}<br>
                    {{ $order->address->address_line1 }}<br>
                    @if ($order->address->address_line2)
                        {{ $order->address->address_line2 }}<br>
                    @endif
                    {{ $order->address->city }}, {{ $order->address->state }} {{ $order->address->postal_code }}<br>
                    {{ $order->address->country }}<br>
                    Tel: {{ $order->address->phone }}
                </address>
            </div>

            <div class="mt-4">
                <div class="flex justify-between mb-2">
                    <span class="font-medium">Subtotal:</span>
                    <span>{{ $order->formatted_subtotal }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="font-medium">Impuestos:</span>
                    <span>{{ $order->formatted_tax_amount }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold">
                    <span>Total:</span>
                    <span>{{ $order->formatted_total }}</span>
                </div>
            </div>

            <div class="mt-8">
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Volver a la Tienda
                </a>
            </div>
        </div>
    </div>
@endsection
