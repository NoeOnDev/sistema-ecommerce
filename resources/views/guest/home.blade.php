@extends('layouts.app')

@section('content')
    <div class="bg-gradient-to-r from-indigo-500 to-indigo-700 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div>
                    <h1 class="text-4xl font-bold mb-4">¡Bienvenido a nuestra tienda en línea!</h1>
                    <p class="text-xl mb-6">Descubre productos increíbles a precios incomparables.</p>
                    <div class="flex space-x-4">
                        <a href="{{ route('products.index') }}" class="bg-white text-indigo-700 px-6 py-3 rounded-lg font-bold shadow-lg hover:bg-gray-100 transition">
                            Ver productos
                        </a>
                        @guest
                            <a href="{{ route('login') }}" class="bg-transparent border-2 border-white px-6 py-3 rounded-lg font-bold hover:bg-white hover:text-indigo-700 transition">
                                Iniciar sesión
                            </a>
                        @endguest
                    </div>
                </div>
                <div class="hidden md:block">
                    <img src="{{ asset('images/hero-image.jpg') }}" alt="Shopping" class="rounded-lg shadow-xl">
                </div>
            </div>
        </div>
    </div>

    <!-- Categorías destacadas -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Categorías Destacadas</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach(App\Models\Category::take(4)->get() as $category)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                        <div class="h-40 bg-indigo-100 flex items-center justify-center">
                            <span class="text-4xl text-indigo-400">
                                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="p-6">
                            <h3 class="font-bold text-xl mb-2 text-gray-800">{{ $category->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit($category->description ?? 'Explora productos en esta categoría', 80) }}</p>
                            <a href="{{ route('products.index', ['category_id' => $category->id]) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                Explorar →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Productos destacados -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Productos Destacados</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach(App\Models\Product::inRandomOrder()->take(8)->get() as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500">Sin imagen</span>
                            </div>
                        @endif
                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-1 text-gray-800">{{ Str::limit($product->name, 40) }}</h3>
                            <p class="text-gray-500 text-sm mb-2">{{ Str::limit($product->description, 60) }}</p>
                            <div class="flex justify-between items-center mt-4">
                                <span class="text-lg font-bold text-indigo-700">{{ $product->formatted_price }}</span>
                                <a href="{{ route('products.show', $product) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 transition">
                                    Ver detalles
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                    Ver todos los productos
                </a>
            </div>
        </div>
    </div>

    <!-- Banner de registro -->
    @guest
    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-indigo-700 rounded-lg shadow-xl overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="p-8 md:p-12">
                        <h2 class="text-3xl font-bold text-white mb-4">¿Aún no tienes una cuenta?</h2>
                        <p class="text-indigo-100 mb-6">Regístrate para disfrutar de ofertas exclusivas, seguimiento de pedidos y mucho más.</p>
                        <div>
                            <a href="{{ route('register') }}" class="inline-block bg-white text-indigo-700 px-6 py-3 rounded-lg font-bold shadow-lg hover:bg-gray-100 transition">
                                Crear cuenta
                            </a>
                        </div>
                    </div>
                    <div class="hidden md:block relative">
                        <img src="{{ asset('images/signup-image.jpg') }}" alt="Sign up" class="absolute inset-0 w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endguest

    <!-- Características -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-12 text-center">¿Por qué elegirnos?</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 text-indigo-600 mb-4">
                        <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17C5.06 5.687 5 5.35 5 5zm4 1V5a1 1 0 10-1 1h1zm3 0a1 1 0 10-1-1v1h1z" clip-rule="evenodd"></path>
                            <path d="M9 11H3v5a2 2 0 002 2h4v-7zM11 18h4a2 2 0 002-2v-5h-6v7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Productos de Calidad</h3>
                    <p class="text-gray-600">Ofrecemos solo los productos de la más alta calidad para nuestros clientes.</p>
                </div>

                <div class="text-center">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 text-indigo-600 mb-4">
                        <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Precios Competitivos</h3>
                    <p class="text-gray-600">Trabajamos directamente con fabricantes para ofrecerte los mejores precios.</p>
                </div>

                <div class="text-center">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 text-indigo-600 mb-4">
                        <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Envío Rápido</h3>
                    <p class="text-gray-600">Procesamos tus pedidos rápidamente para que los recibas en tiempo récord.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
