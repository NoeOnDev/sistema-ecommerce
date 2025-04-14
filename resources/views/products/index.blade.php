@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Catálogo de Productos</h1>

        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <form method="GET" class="space-y-3 md:flex md:space-y-0 md:space-x-4 md:items-end">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                    <input type="text" name="search" placeholder="Buscar productos..." value="{{ request('search') }}"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div class="flex-1">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                    <select name="category_id"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Todas las categorías</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full md:w-auto">
                        Buscar
                    </button>
                </div>
            </form>
        </div>

        <div class="flex justify-between mb-4">
            @auth
                @if (Auth::user()->isAdmin())
                    <a href="{{ route('products.create') }}"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Crear Producto
                    </a>
                @endif
            @endauth
        </div>

        <!-- Grid de productos -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                    <div class="relative h-48 overflow-hidden">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500">
                                <span>Sin imagen</span>
                            </div>
                        @endif
                        @if ($product->stock <= 0)
                            <div class="absolute top-2 right-2 bg-red-600 text-white px-2 py-1 rounded-md text-xs font-semibold">
                                Agotado
                            </div>
                        @endif
                    </div>

                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1 line-clamp-2 h-14">
                            <a href="{{ route('products.show', $product) }}" class="hover:text-indigo-600">
                                {{ $product->name }}
                            </a>
                        </h3>

                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600 text-sm">{{ $product->category->name }}</span>
                            <span class="text-sm">Stock: {{ $product->stock }}</span>
                        </div>

                        <div class="flex justify-between items-center mb-4">
                            <span class="text-xl font-bold text-indigo-700">{{ $product->formatted_price }}</span>
                        </div>

                        <div class="flex flex-col space-y-2">
                            <form action="{{ route('cart.add') }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit"
                                    class="w-full flex items-center justify-center py-2 px-4 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md shadow-sm focus:outline-none {{ $product->stock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Agregar al Carrito
                                </button>
                            </form>

                            <a href="{{ route('products.show', $product) }}"
                                class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                                Ver Detalles
                            </a>

                            @auth
                                @if (Auth::user()->isAdmin())
                                    <div class="flex space-x-2 pt-2 border-t border-gray-100">
                                        <a href="{{ route('products.edit', $product) }}"
                                            class="flex-1 flex items-center justify-center text-indigo-600 hover:text-indigo-900 text-xs py-1">
                                            Editar
                                        </a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full flex items-center justify-center text-red-600 hover:text-red-900 text-xs py-1"
                                                onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($products->isEmpty())
            <div class="bg-white shadow-md rounded-lg p-8 text-center">
                <p class="text-gray-500 text-lg">No se encontraron productos que coincidan con tu búsqueda.</p>
                <a href="{{ route('products.index') }}" class="mt-4 inline-block text-indigo-600 hover:underline">Ver todos los productos</a>
            </div>
        @endif

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
@endsection
