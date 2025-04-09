@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ $product->name }}</h1>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="md:flex">
                <div class="md:w-1/2">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-auto object-cover"
                            alt="{{ $product->name }}">
                    @else
                        <div class="bg-gray-200 h-64 flex items-center justify-center">
                            <span class="text-gray-500 text-lg">Sin imagen</span>
                        </div>
                    @endif
                </div>
                <div class="md:w-1/2 p-6">
                    <div class="prose max-w-none">
                        <p class="text-gray-700 mb-4">{{ $product->description }}</p>

                        <div class="mb-4">
                            <span class="font-bold text-gray-700">Precio:</span>
                            <span
                                class="text-green-600 text-xl font-semibold">${{ number_format($product->price, 2) }}</span>
                        </div>

                        <div class="mb-4">
                            <span class="font-bold text-gray-700">Stock:</span>
                            <span class="text-gray-600">{{ $product->stock }} unidades</span>
                        </div>

                        <div class="mb-4">
                            <span class="font-bold text-gray-700">Categoría:</span>
                            <span class="text-gray-600">{{ $product->category->name }}</span>
                        </div>

                        @if ($product->tags->count() > 0)
                            <div class="mb-6">
                                <span class="font-bold text-gray-700">Etiquetas:</span>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach ($product->tags as $tag)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="flex space-x-3 mt-6">
                            <a href="{{ route('products.edit', $product) }}"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                Editar
                            </a>
                            <a href="{{ route('products.index') }}"
                                class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Volver
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
