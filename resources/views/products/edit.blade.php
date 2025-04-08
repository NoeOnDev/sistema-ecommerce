@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Producto</h1>

        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="name">Nombre</label>
                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="description">Descripción</label>
                <textarea name="description" class="form-control">{{ $product->description }}</textarea>
            </div>
            <div class="form-group mb-3">
                <label for="price">Precio</label>
                <input type="number" name="price" class="form-control" value="{{ $product->price }}" step="0.01"
                    required>
            </div>
            <div class="form-group mb-3">
                <label for="stock">Stock</label>
                <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="category_id">Categoría</label>
                <select name="category_id" class="form-control" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="tags">Etiquetas</label>
                <select name="tags[]" class="form-control" multiple>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}" {{ $product->tags->contains($tag->id) ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="image">Imagen</label>
                @if ($product->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $product->image) }}" width="100" alt="{{ $product->name }}">
                    </div>
                @endif
                <input type="file" name="image" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
