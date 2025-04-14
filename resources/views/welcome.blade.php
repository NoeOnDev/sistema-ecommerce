@extends('layouts.app')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h1 class="text-4xl font-bold text-gray-800">¡Bienvenido al Sistema E-commerce!</h1>
        <p class="text-xl text-gray-600 mt-2">Sistema de gestión de productos para tu tienda en línea.</p>
        <hr class="my-4 border-gray-300">
        <p class="text-gray-700 mb-4">Utiliza el menú de navegación para administrar los productos de tu catálogo.</p>
        <a href="{{ route('products.index') }}"
            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Ver Productos
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <h5 class="text-lg font-bold mb-2">Gestión de Productos</h5>
                <p class="text-gray-700 mb-4">Crea, edita y elimina productos de tu catálogo.</p>
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Ir a Productos
                </a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <h5 class="text-lg font-bold mb-2">Categorías</h5>
                <p class="text-gray-700 mb-4">Organiza tus productos por categorías.</p>
                <a href="#"
                    class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                    Próximamente
                </a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <h5 class="text-lg font-bold mb-2">Etiquetas</h5>
                <p class="text-gray-700 mb-4">Mejora la búsqueda de productos con etiquetas.</p>
                <a href="#"
                    class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                    Próximamente
                </a>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <h2 class="text-2xl font-bold mb-4">Productos destacados</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach (App\Models\Product::orderBy('created_at', 'desc')->take(3)->get() as $product)
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-48 object-cover"
                            alt="{{ $product->name }}">
                    @else
                        <div class="bg-gray-400 text-white p-6 text-center h-48 flex items-center justify-center">
                            <span>Sin imagen</span>
                        </div>
                    @endif
                    <div class="p-6">
                        <h5 class="text-lg font-bold mb-2">{{ $product->name }}</h5>
                        <p class="text-gray-700 mb-2">{{ Str::limit($product->description, 100) }}</p>
                        <p class="text-gray-800 font-semibold mb-4">Precio: {{ $product->formatted_price }}</p>
                        <a href="{{ route('products.show', $product) }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Ver detalles
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
