@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Revisión del Pedido</h1>

        <div class="mb-4">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center mr-2">1</div>
                <span class="font-medium">Revisión</span>
                <div class="h-0.5 w-8 bg-gray-300 mx-2"></div>
                <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center mr-2">2</div>
                <span class="text-gray-600">Envío</span>
                <div class="h-0.5 w-8 bg-gray-300 mx-2"></div>
                <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center mr-2">3</div>
                <span class="text-gray-600">Pago</span>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Producto
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Precio
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Cantidad
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Subtotal
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($cart->items as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($item->product->image)
                                            <img class="h-10 w-10 rounded-md object-cover" src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                                        @else
                                            <div class="h-10 w-10 rounded-md bg-gray-300 flex items-center justify-center text-gray-500">
                                                <span class="text-xs">Sin imagen</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $item->product->name }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">${{ number_format($item->price, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $item->quantity }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    ${{ number_format($item->subtotal, 2) }}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between mb-2">
                <span class="font-medium">Subtotal:</span>
                <span>${{ number_format($cart->subtotal, 2) }}</span>
            </div>
            <div class="flex justify-between mb-2">
                <span class="font-medium">Impuestos ({{ $cart->tax_rate }}%):</span>
                <span>${{ number_format($cart->tax_amount, 2) }}</span>
            </div>
            <div class="flex justify-between text-lg font-bold">
                <span>Total:</span>
                <span>${{ number_format($cart->total, 2) }}</span>
            </div>

            <div class="mt-6 flex justify-between">
                <a href="{{ route('cart.index') }}" class="py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Volver al Carrito
                </a>

                <a href="{{ route('checkout.shipping') }}" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Continuar con el Envío
                </a>
            </div>
        </div>
    </div>
@endsection
