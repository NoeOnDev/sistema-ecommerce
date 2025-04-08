@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $product->name }}</h1>

        <div class="row">
            <div class="col-md-6">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid" alt="{{ $product->name }}">
                @else
                    <div class="bg-secondary text-white p-5 text-center">Sin imagen</div>
                @endif
            </div>
            <div class="col-md-6">
                <p class="lead">{{ $product->description }}</p>
                <p><strong>Precio:</strong> ${{ number_format($product->price, 2) }}</p>
                <p><strong>Stock:</strong> {{ $product->stock }}</p>
                <p><strong>Categoría:</strong> {{ $product->category->name }}</p>

                @if ($product->tags->count() > 0)
                    <p><strong>Etiquetas:</strong>
                        @foreach ($product->tags as $tag)
                            <span class="badge bg-secondary">{{ $tag->name }}</span>
                        @endforeach
                    </p>
                @endif

                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Editar</a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </div>
    </div>
@endsection
