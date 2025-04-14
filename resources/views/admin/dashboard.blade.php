@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Panel de Administración</h1>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
            <h2 class="text-xl font-semibold mb-4">Estadísticas</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-blue-100 p-4 rounded-lg text-center">
                    <span class="text-3xl font-bold text-blue-800">{{ App\Models\Product::count() }}</span>
                    <p class="text-blue-600">Productos</p>
                </div>
                <div class="bg-green-100 p-4 rounded-lg text-center">
                    <span class="text-3xl font-bold text-green-800">{{ App\Models\Order::count() }}</span>
                    <p class="text-green-600">Pedidos</p>
                </div>
                <div class="bg-yellow-100 p-4 rounded-lg text-center">
                    <span class="text-3xl font-bold text-yellow-800">{{ App\Models\Order::where('status', 'pending')->count() }}</span>
                    <p class="text-yellow-600">Pendientes</p>
                </div>
                <div class="bg-indigo-100 p-4 rounded-lg text-center">
                    <span class="text-3xl font-bold text-indigo-800">{{ App\Models\User::where('role', 'cliente')->count() }}</span>
                    <p class="text-indigo-600">Clientes</p>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Productos Recientes</h2>
                <a href="{{ route('products.create') }}" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded">Añadir Producto</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach(App\Models\Product::latest()->take(5)->get() as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $product->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $product->formatted_price }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $product->stock }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900 pr-2">Editar</a>
                                <a href="{{ route('products.show', $product) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-right">
                <a href="{{ route('products.index') }}" class="text-indigo-600 hover:text-indigo-900">Ver todos los productos →</a>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Últimos Pedidos</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Número</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach(App\Models\Order::with('user')->latest()->take(5)->get() as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->order_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->user ? $order->user->name : 'Invitado' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->formatted_total }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' :
                                      ($order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                       'bg-blue-100 text-blue-800') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
