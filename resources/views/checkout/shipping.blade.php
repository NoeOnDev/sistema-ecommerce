@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Información de Envío</h1>

        <div class="mb-4">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center mr-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </div>
                <span class="text-gray-600">Revisión</span>
                <div class="h-0.5 w-8 bg-gray-300 mx-2"></div>
                <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center mr-2">2</div>
                <span class="font-medium">Envío</span>
                <div class="h-0.5 w-8 bg-gray-300 mx-2"></div>
                <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center mr-2">3</div>
                <span class="text-gray-600">Pago</span>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('checkout.process.shipping') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                        <input type="text" name="first_name" id="first_name" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('first_name', $user->name ?? '') }}" required>
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Apellidos</label>
                        <input type="text" name="last_name" id="last_name" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('last_name') }}" required>
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('email', $user->email ?? '') }}" required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                        <input type="text" name="phone" id="phone" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('phone') }}" required>
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="address_line1" class="block text-sm font-medium text-gray-700 mb-1">Dirección Línea 1</label>
                        <input type="text" name="address_line1" id="address_line1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('address_line1') }}" required>
                        @error('address_line1')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="address_line2" class="block text-sm font-medium text-gray-700 mb-1">Dirección Línea 2 (Opcional)</label>
                        <input type="text" name="address_line2" id="address_line2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('address_line2') }}">
                        @error('address_line2')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Ciudad</label>
                        <input type="text" name="city" id="city" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('city') }}" required>
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700 mb-1">Estado/Provincia</label>
                        <input type="text" name="state" id="state" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('state') }}" required>
                        @error('state')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Código Postal</label>
                        <input type="text" name="postal_code" id="postal_code" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('postal_code') }}" required>
                        @error('postal_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-1">País</label>
                        <input type="text" name="country" id="country" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('country', 'México') }}" required>
                        @error('country')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-between">
                    <a href="{{ route('checkout.review') }}" class="py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Volver
                    </a>

                    <button type="submit" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Continuar al Pago
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-6 bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-2">Resumen del Pedido</h2>
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
@endsection
