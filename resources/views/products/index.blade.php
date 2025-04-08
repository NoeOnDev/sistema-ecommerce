@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Listado de Productos</h1>

        <form method="GET" class="mb-4">
            <input type="text" name="search" placeholder="Buscar productos..." value="{{ request('search') }}"
                class="form-control mb-2">
            <select name="category_id" class="form-control mb-2">
                <option value="">Todas las categorías</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <a href="{{ route('products.create') }}" class="btn btn-success mb-3">Crear Producto</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>
                            <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                        </td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm">Ver detalles</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $products->links() }}
    </div>
@endsection
