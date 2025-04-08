@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <h1 class="display-4">¡Bienvenido al Sistema E-commerce!</h1>
        <p class="lead">Sistema de gestión de productos para tu tienda en línea.</p>
        <hr class="my-4">
        <p>Utiliza el menú de navegación para administrar los productos de tu catálogo.</p>
        <a class="btn btn-primary btn-lg" href="{{ route('products.index') }}" role="button">Ver Productos</a>
    </div>

    <div class="row mt-5">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Gestión de Productos</h5>
                    <p class="card-text">Crea, edita y elimina productos de tu catálogo.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Ir a Productos</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Categorías</h5>
                    <p class="card-text">Organiza tus productos por categorías.</p>
                    <a href="#" class="btn btn-secondary">Próximamente</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Etiquetas</h5>
                    <p class="card-text">Mejora la búsqueda de productos con etiquetas.</p>
                    <a href="#" class="btn btn-secondary">Próximamente</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <h2>Productos destacados</h2>
            <div class="row">
                @foreach(App\Models\Product::orderBy('created_at', 'desc')->take(3)->get() as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            @else
                                <div class="bg-secondary text-white p-5 text-center">Sin imagen</div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                <p class="card-text"><strong>Precio:</strong> ${{ number_format($product->price, 2) }}</p>
                                <a href="{{ route('products.show', $product) }}" class="btn btn-primary">Ver detalles</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
