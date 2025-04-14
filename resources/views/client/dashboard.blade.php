@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Mi Cuenta</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Sección de información del cliente -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-100 rounded-full p-3 mr-3">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold">Información Personal</h2>
                </div>
                <div class="border-t border-gray-200 pt-4">
                    <p class="text-gray-600 mb-2">
                        <span class="font-medium">Nombre:</span> {{ Auth::user()->name }}
                    </p>
                    <p class="text-gray-600 mb-2">
                        <span class="font-medium">Email:</span> {{ Auth::user()->email }}
                    </p>
                    <p class="text-gray-600">
                        <span class="font-medium">Miembro desde:</span> {{ Auth::user()->created_at->format('d/m/Y') }}
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('profile.edit') }}" class="text-indigo-600 hover:text-indigo-900">Editar información →</a>
                    </div>
                </div>
            </div>

            <!-- Sección de pedidos recientes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 md:col-span-2">
                <div class="flex items-center mb-4">
                    <div class="bg-green-100 rounded-full p-3 mr-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold">Mis Pedidos Recientes</h2>
                </div>
                <div class="border-t border-gray-200 pt-4">
                    @if(Auth::user()->orders && Auth::user()->orders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Número</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach(Auth::user()->orders()->latest()->take(5)->get() as $order)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->order_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->created_at->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->formatted_total }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' :
                                                ($order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                                'bg-blue-100 text-blue-800') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-600">No has realizado ningún pedido todavía.</p>
                    @endif
                </div>
            </div>

            <!-- Acciones rápidas -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <div class="bg-yellow-100 rounded-full p-3 mr-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold">Acciones Rápidas</h2>
                </div>
                <div class="border-t border-gray-200 pt-4">
                    <div class="space-y-3">
                        <a href="{{ route('products.index') }}" class="block bg-gray-100 hover:bg-gray-200 p-3 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <span>Explorar Productos</span>
                            </div>
                        </a>
                        <a href="{{ route('cart.index') }}" class="block bg-gray-100 hover:bg-gray-200 p-3 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span>Ver Mi Carrito</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sección de recomendaciones -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 md:col-span-2">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 rounded-full p-3 mr-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold">Productos Recomendados</h2>
                </div>
                <div class="border-t border-gray-200 pt-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach(App\Models\Product::inRandomOrder()->take(3)->get() as $product)
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-32 object-cover">
                            @else
                                <div class="w-full h-32 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">Sin imagen</span>
                                </div>
                            @endif
                            <div class="p-3">
                                <h3 class="font-medium text-gray-800">{{ Str::limit($product->name, 20) }}</h3>
                                <p class="text-indigo-600 font-semibold mt-1">{{ $product->formatted_price }}</p>
                                <a href="{{ route('products.show', $product) }}" class="mt-2 text-sm text-blue-600 hover:text-blue-800 block">
                                    Ver detalles →
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
