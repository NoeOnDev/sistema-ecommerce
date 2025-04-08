@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Crear Producto</h1>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="name">Nombre</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="description">Descripción</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="price">Precio</label>
                <input type="number" name="price" class="form-control" step="0.01" required>
            </div>
            <div class="form-group mb-3">
                <label for="stock">Stock</label>
                <input type="number" name="stock" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="category_id">Categoría</label>
                <select name="category_id" class="form-control" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="tags">Etiquetas</label>
                <select name="tags[]" class="form-control" multiple>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="image">Imagen</label>
                <input type="file" name="image" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
