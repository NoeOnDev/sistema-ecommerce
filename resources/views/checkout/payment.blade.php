@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Método de Pago</h1>

        <div class="mb-4">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center mr-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </div>
                <span class="text-gray-600">Revisión</span>
                <div class="h-0.5 w-8 bg-gray-300 mx-2"></div>
                <div class="w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center mr-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </div>
                <span class="text-gray-600">Envío</span>
                <div class="h-0.5 w-8 bg-gray-300 mx-2"></div>
                <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center mr-2">3</div>
                <span class="font-medium">Pago</span>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('checkout.process.payment') }}" method="POST" id="payment-form">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Selecciona un método de pago</label>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <input type="radio" name="payment_method" id="credit_card" value="credit_card" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" checked>
                            <label for="credit_card" class="ml-3 block text-sm font-medium text-gray-700">
                                Tarjeta de Crédito / Débito
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" name="payment_method" id="paypal" value="paypal" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                            <label for="paypal" class="ml-3 block text-sm font-medium text-gray-700">
                                PayPal
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" name="payment_method" id="bank_transfer" value="bank_transfer" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                            <label for="bank_transfer" class="ml-3 block text-sm font-medium text-gray-700">
                                Transferencia Bancaria
                            </label>
                        </div>
                    </div>
                    @error('payment_method')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div id="credit-card-form" class="border-t border-gray-200 pt-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Detalles de la Tarjeta</h3>
                    <p class="mb-3 text-sm text-gray-500">Este es un formulario de simulación. No ingreses datos reales de tarjetas.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="card_number" class="block text-sm font-medium text-gray-700 mb-1">Número de Tarjeta</label>
                            <input type="text" name="card_number" id="card_number" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="4242 4242 4242 4242">
                            @error('card_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="card_holder" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Titular</label>
                            <input type="text" name="card_holder" id="card_holder" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('card_holder')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="card_expiry" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Expiración (MM/AA)</label>
                            <input type="text" name="card_expiry" id="card_expiry" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="MM/YY">
                            @error('card_expiry')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="card_cvv" class="block text-sm font-medium text-gray-700 mb-1">Código de Seguridad (CVV)</label>
                            <input type="text" name="card_cvv" id="card_cvv" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="123">
                            @error('card_cvv')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-between">
                    <a href="{{ route('checkout.shipping') }}" class="py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Volver
                    </a>

                    <button type="submit" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Finalizar Compra
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-6 bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-2">Resumen del Pedido</h2>
            <div class="border-b border-gray-200 pb-4 mb-4">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Productos:</h3>
                @foreach($cart->items as $item)
                    <div class="flex justify-between text-sm mb-1">
                        <span>{{ $item->product->name }} ({{ $item->quantity }})</span>
                        <span>${{ number_format($item->subtotal, 2) }}</span>
                    </div>
                @endforeach
            </div>
            <div class="border-b border-gray-200 pb-4 mb-4">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Dirección de Envío:</h3>
                <address class="text-sm not-italic">
                    {{ $address['first_name'] }} {{ $address['last_name'] }}<br>
                    {{ $address['address_line1'] }}<br>
                    @if($address['address_line2'])
                        {{ $address['address_line2'] }}<br>
                    @endif
                    {{ $address['city'] }}, {{ $address['state'] }} {{ $address['postal_code'] }}<br>
                    {{ $address['country'] }}<br>
                    Tel: {{ $address['phone'] }}
                </address>
            </div>
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
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethodRadios = document.querySelectorAll('input[name="payment_method"]');
            const creditCardForm = document.getElementById('credit-card-form');

            function toggleCreditCardForm() {
                const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
                if (selectedMethod === 'credit_card') {
                    creditCardForm.classList.remove('hidden');
                } else {
                    creditCardForm.classList.add('hidden');
                }
            }

            paymentMethodRadios.forEach(radio => {
                radio.addEventListener('change', toggleCreditCardForm);
            });

            toggleCreditCardForm(); // Initial toggle
        });
    </script>
@endsection
