<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Aseguramos que existe el directorio para las imágenes
        Storage::disk('public')->makeDirectory('products');

        // Obtenemos las categorías y etiquetas
        $electronica = Category::where('name', 'Electrónica')->first();
        $ropa = Category::where('name', 'Ropa')->first();
        $hogar = Category::where('name', 'Hogar')->first();
        $deportes = Category::where('name', 'Deportes')->first();
        $belleza = Category::where('name', 'Belleza')->first();

        // Etiquetas comunes
        $nuevo = Tag::where('name', 'Nuevo')->first();
        $destacado = Tag::where('name', 'Destacado')->first();
        $oferta = Tag::where('name', 'Oferta')->first();
        $bestseller = Tag::where('name', 'Bestseller')->first();
        $premium = Tag::where('name', 'Premium')->first();

        // Lista de productos
        $products = [
            [
                'name' => 'Smartphone Galaxy S23',
                'description' => 'El último smartphone de Samsung con cámara avanzada y batería de larga duración',
                'price' => 899.99,
                'stock' => 25,
                'category_id' => $electronica->id,
                'tags' => [$nuevo->id, $destacado->id],
                'image_name' => 'smartphone.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1709744722656-9b850470293f?q=80&w=500'
            ],
            [
                'name' => 'Smartwatch Pro',
                'description' => 'Reloj inteligente con monitorización de salud y notificaciones',
                'price' => 249.99,
                'stock' => 30,
                'category_id' => $electronica->id,
                'tags' => [$nuevo->id, $oferta->id],
                'image_name' => 'smartwatch.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1640039344494-13df103be810?q=80&w=500'
            ],
            [
                'name' => 'Zapatillas Running Elite',
                'description' => 'Zapatillas deportivas con tecnología de amortiguación avanzada',
                'price' => 129.99,
                'stock' => 45,
                'category_id' => $deportes->id,
                'tags' => [$destacado->id, $bestseller->id],
                'image_name' => 'zapatillas.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1586348052423-035b02a15fd8?q=80&w=500'
            ],
            [
                'name' => 'Chamarra Impermeable',
                'description' => 'Chamarra resistente al agua ideal para actividades al aire libre',
                'price' => 89.99,
                'stock' => 20,
                'category_id' => $ropa->id,
                'tags' => [$oferta->id],
                'image_name' => 'chamarra.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=500'
            ],
            [
                'name' => 'Cafetera Automática',
                'description' => 'Cafetera con timer programable y múltiples funciones',
                'price' => 65.50,
                'stock' => 15,
                'category_id' => $hogar->id,
                'tags' => [$bestseller->id],
                'image_name' => 'cafetera.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1637029436347-e33bf98a5412?q=80&w=500'
            ],
            [
                'name' => 'Set de Sartenes Antiadherentes',
                'description' => 'Juego de 3 sartenes con recubrimiento antiadherente de alta calidad',
                'price' => 79.99,
                'stock' => 10,
                'category_id' => $hogar->id,
                'tags' => [$premium->id],
                'image_name' => 'sartenes.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1588279102819-f4520e40b1c6?q=80&w=500'
            ],
            [
                'name' => 'Crema Facial Hidratante',
                'description' => 'Crema facial con ácido hialurónico para una hidratación profunda',
                'price' => 34.99,
                'stock' => 50,
                'category_id' => $belleza->id,
                'tags' => [$nuevo->id, $premium->id],
                'image_name' => 'crema.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1571781926291-c477ebfd024b?q=80&w=500'
            ],
            [
                'name' => 'Auriculares Bluetooth',
                'description' => 'Auriculares inalámbricos con cancelación de ruido y alta fidelidad',
                'price' => 159.99,
                'stock' => 35,
                'category_id' => $electronica->id,
                'tags' => [$destacado->id, $bestseller->id],
                'image_name' => 'auriculares.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?q=80&w=500'
            ],
            [
                'name' => 'Mochila Impermeable',
                'description' => 'Mochila con compartimentos para laptop y materiales resistentes al agua',
                'price' => 45.99,
                'stock' => 40,
                'category_id' => $deportes->id,
                'tags' => [$oferta->id],
                'image_name' => 'mochila.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?q=80&w=500'
            ],
            [
                'name' => 'Tabla de Cortar de Bambú',
                'description' => 'Tabla de cocina ecológica hecha de bambú sostenible',
                'price' => 24.50,
                'stock' => 25,
                'category_id' => $hogar->id,
                'tags' => [$nuevo->id],
                'image_name' => 'tabla.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1645743714610-b46ff94f658d?q=80&w=500'
            ],
            [
                'name' => 'Vestido Casual',
                'description' => 'Vestido elegante para ocasiones casuales',
                'price' => 59.99,
                'stock' => 15,
                'category_id' => $ropa->id,
                'tags' => [$nuevo->id, $destacado->id],
                'image_name' => 'vestido.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1618932260643-eee4a2f652a6?q=80&w=500'
            ],
            [
                'name' => 'Perfume Esencia',
                'description' => 'Fragancia exclusiva con notas cítricas y amaderadas',
                'price' => 85.00,
                'stock' => 20,
                'category_id' => $belleza->id,
                'tags' => [$premium->id, $bestseller->id],
                'image_name' => 'perfume.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1664470740442-f5de3e512e8b?q=80&w=500'
            ]
        ];

        foreach ($products as $productData) {
            // Descargar imagen y guardarla
            $imagePath = $this->downloadAndSaveImage(
                $productData['image_url'],
                'products/' . $productData['image_name']
            );

            // Crear el producto
            $product = Product::create([
                'name' => $productData['name'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'stock' => $productData['stock'],
                'image' => $imagePath,
                'slug' => Str::slug($productData['name']),
                'category_id' => $productData['category_id'],
                'active' => true,
            ]);

            // Asignar etiquetas
            $product->tags()->attach($productData['tags']);
        }
    }

    /**
     * Descarga una imagen desde URL y la guarda en storage
     */
    private function downloadAndSaveImage($url, $path)
    {
        try {
            // Intentamos descargar la imagen
            $contents = file_get_contents($url);

            // La guardamos en storage/public/
            Storage::disk('public')->put($path, $contents);

            return $path;
        } catch (\Exception $e) {
            // Si falla, retornamos null y no tendrá imagen
            return null;
        }
    }
}
