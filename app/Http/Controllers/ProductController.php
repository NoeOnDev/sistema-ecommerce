<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Búsqueda por nombre
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filtro por categoría
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->with('category')->paginate(10);
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('products.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        // Generar slug
        $validated['slug'] = Str::slug($validated['name']);

        // Subir imagen
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product = Product::create($validated);

        // Asignar tags
        if ($request->has('tags')) {
            $product->tags()->attach($request->tags);
        }

        return redirect()->route('products.index')
            ->with('success', 'Producto creado correctamente');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('products.edit', compact('product', 'categories', 'tags'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        // Generar slug
        $validated['slug'] = Str::slug($validated['name']);

        // Subir imagen
        if ($request->hasFile('image')) {
            // Eliminar imagen anterior si existe
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);

        // Actualizar tags
        if ($request->has('tags')) {
            $product->tags()->sync($request->tags);
        } else {
            $product->tags()->detach();
        }

        return redirect()->route('products.index')
            ->with('success', 'Producto actualizado correctamente');
    }

    public function destroy(Product $product)
    {
        // Eliminar imagen si existe
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Producto eliminado correctamente');
    }
}
