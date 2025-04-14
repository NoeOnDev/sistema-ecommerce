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
    // Definir constante para la moneda
    private const CURRENCY = 'MXN';

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

        // Lista de productos con precios realistas en Pesos Mexicanos (MXN)
        $products = [
            [
                'name' => 'Smartphone Galaxy S23',
                'description' => 'El último smartphone de Samsung con cámara avanzada y batería de larga duración',
                'price' => 18999.00,
                'stock' => 25,
                'category_id' => $electronica->id,
                'tags' => [$nuevo->id, $destacado->id],
                'image_name' => 'smartphone.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1709744722656-9b850470293f?q=80&w=500'
            ],
            [
                'name' => 'Smartwatch Pro',
                'description' => 'Reloj inteligente con monitorización de salud y notificaciones',
                'price' => 4999.00,
                'stock' => 30,
                'category_id' => $electronica->id,
                'tags' => [$nuevo->id, $oferta->id],
                'image_name' => 'smartwatch.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1640039344494-13df103be810?q=80&w=500'
            ],
            [
                'name' => 'Zapatillas Running Elite',
                'description' => 'Zapatillas deportivas con tecnología de amortiguación avanzada',
                'price' => 1899.00,
                'stock' => 45,
                'category_id' => $deportes->id,
                'tags' => [$destacado->id, $bestseller->id],
                'image_name' => 'zapatillas.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1586348052423-035b02a15fd8?q=80&w=500'
            ],
            [
                'name' => 'Chamarra Impermeable',
                'description' => 'Chamarra resistente al agua ideal para actividades al aire libre',
                'price' => 1299.00,
                'stock' => 20,
                'category_id' => $ropa->id,
                'tags' => [$oferta->id],
                'image_name' => 'chamarra.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=500'
            ],
            [
                'name' => 'Cafetera Automática',
                'description' => 'Cafetera con timer programable y múltiples funciones',
                'price' => 1250.00,
                'stock' => 15,
                'category_id' => $hogar->id,
                'tags' => [$bestseller->id],
                'image_name' => 'cafetera.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1637029436347-e33bf98a5412?q=80&w=500'
            ],
            [
                'name' => 'Set de Sartenes',
                'description' => 'Juego de 3 sartenes con recubrimiento antiadherente de alta calidad',
                'price' => 1499.00,
                'stock' => 10,
                'category_id' => $hogar->id,
                'tags' => [$premium->id],
                'image_name' => 'sartenes.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1588279102819-f4520e40b1c6?q=80&w=500'
            ],
            [
                'name' => 'Crema Facial Hidratante',
                'description' => 'Crema facial con ácido hialurónico para una hidratación profunda',
                'price' => 649.00,
                'stock' => 50,
                'category_id' => $belleza->id,
                'tags' => [$nuevo->id, $premium->id],
                'image_name' => 'crema.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1571781926291-c477ebfd024b?q=80&w=500'
            ],
            [
                'name' => 'Auriculares Bluetooth',
                'description' => 'Auriculares inalámbricos con cancelación de ruido y alta fidelidad',
                'price' => 2499.00,
                'stock' => 35,
                'category_id' => $electronica->id,
                'tags' => [$destacado->id, $bestseller->id],
                'image_name' => 'auriculares.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?q=80&w=500'
            ],
            [
                'name' => 'Mochila Impermeable',
                'description' => 'Mochila con compartimentos para laptop y materiales resistentes al agua',
                'price' => 899.00,
                'stock' => 40,
                'category_id' => $deportes->id,
                'tags' => [$oferta->id],
                'image_name' => 'mochila.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?q=80&w=500'
            ],
            [
                'name' => 'Tabla de Cortar de Bambú',
                'description' => 'Tabla de cocina ecológica hecha de bambú sostenible',
                'price' => 399.00,
                'stock' => 25,
                'category_id' => $hogar->id,
                'tags' => [$nuevo->id],
                'image_name' => 'tabla.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1645743714610-b46ff94f658d?q=80&w=500'
            ],
            [
                'name' => 'Vestido Casual',
                'description' => 'Vestido elegante para ocasiones casuales',
                'price' => 849.00,
                'stock' => 15,
                'category_id' => $ropa->id,
                'tags' => [$nuevo->id, $destacado->id],
                'image_name' => 'vestido.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1618932260643-eee4a2f652a6?q=80&w=500'
            ],
            [
                'name' => 'Perfume Esencia',
                'description' => 'Fragancia exclusiva con notas cítricas y amaderadas',
                'price' => 1349.00,
                'stock' => 20,
                'category_id' => $belleza->id,
                'tags' => [$premium->id, $bestseller->id],
                'image_name' => 'perfume.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1664470740442-f5de3e512e8b?q=80&w=500'
            ],
            [
                'name' => 'Laptop Ultradelgada',
                'description' => 'Laptop de alto rendimiento con procesador de última generación y diseño ultradelgado',
                'price' => 21499.00,
                'stock' => 15,
                'category_id' => $electronica->id,
                'tags' => [$nuevo->id, $premium->id],
                'image_name' => 'laptop.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1636211989567-fd3ada526ea0?q=80&w=500'
            ],
            [
                'name' => 'Blusa de Algodón',
                'description' => 'Blusa de algodón orgánico con diseño casual y fresco, perfecta para el día a día',
                'price' => 549.00,
                'stock' => 30,
                'category_id' => $ropa->id,
                'tags' => [$nuevo->id],
                'image_name' => 'blusa.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1562157873-818bc0726f68?q=80&w=500'
            ],
            [
                'name' => 'Juego de Toallas',
                'description' => 'Set de 4 toallas de diferentes tamaños con alta absorción y suavidad',
                'price' => 799.00,
                'stock' => 25,
                'category_id' => $hogar->id,
                'tags' => [$oferta->id, $bestseller->id],
                'image_name' => 'toallas.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1670080607803-e15aa44d3ead?q=80&w=500'
            ],
            [
                'name' => 'Balón de Fútbol Profesional',
                'description' => 'Balón de fútbol de competición con tecnología antideslizante y costura reforzada',
                'price' => 699.00,
                'stock' => 40,
                'category_id' => $deportes->id,
                'tags' => [$destacado->id],
                'image_name' => 'balon.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1571354188019-9a5038b88457?q=80&w=500'
            ],
            [
                'name' => 'Set de Maquillaje Profesional',
                'description' => 'Kit completo de maquillaje con 24 sombras, bases, labiales y brochas de alta calidad',
                'price' => 1299.00,
                'stock' => 18,
                'category_id' => $belleza->id,
                'tags' => [$premium->id],
                'image_name' => 'maquillaje.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1564414564893-a01165b87e1e?q=80&w=500'
            ],
            [
                'name' => 'Jeans Ajustados',
                'description' => 'Jeans de mezclilla premium con corte ajustado y diseño moderno',
                'price' => 899.00,
                'stock' => 35,
                'category_id' => $ropa->id,
                'tags' => [$bestseller->id],
                'image_name' => 'jeans.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1725986266144-cc5813d058e5?q=80&w=500'
            ],
            [
                'name' => 'Aspiradora Inteligente',
                'description' => 'Robot aspiradora con mapeo inteligente, control por aplicación y sistema de navegación láser',
                'price' => 5999.00,
                'stock' => 10,
                'category_id' => $hogar->id,
                'tags' => [$nuevo->id, $premium->id],
                'image_name' => 'aspiradora.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1679872065406-6bc46fabffcd?q=80&w=500'
            ],
            [
                'name' => 'Bicicleta de Montaña',
                'description' => 'Bicicleta todo terreno con suspensión delantera, 21 velocidades y cuadro de aluminio ligero',
                'price' => 7499.00,
                'stock' => 8,
                'category_id' => $deportes->id,
                'tags' => [$destacado->id, $premium->id],
                'image_name' => 'bicicleta.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1724987274624-f3d4008832a0?q=80&w=500'
            ],
            [
                'name' => 'Tableta Gráfica',
                'description' => 'Tableta digitalizadora para diseñadores con 8192 niveles de presión y conexión inalámbrica',
                'price' => 3499.00,
                'stock' => 12,
                'category_id' => $electronica->id,
                'tags' => [$nuevo->id],
                'image_name' => 'tableta.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1627065554182-9489acd66222?q=80&w=500'
            ],
            [
                'name' => 'Aceite Corporal Orgánico',
                'description' => 'Aceite corporal hidratante con ingredientes 100% naturales y aceites esenciales',
                'price' => 399.00,
                'stock' => 45,
                'category_id' => $belleza->id,
                'tags' => [$oferta->id, $nuevo->id],
                'image_name' => 'aceite.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1709813610121-e2a51545e212?q=80&w=500'
            ],
            [
                'name' => 'Juego de Sábanas Premium',
                'description' => 'Set de sábanas de algodón egipcio de 1000 hilos para mayor suavidad y frescura',
                'price' => 1899.00,
                'stock' => 20,
                'category_id' => $hogar->id,
                'tags' => [$premium->id],
                'image_name' => 'sabanas.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1633539091259-dc7024887566?q=80&w=500'
            ],
            [
                'name' => 'Sudadera con Capucha',
                'description' => 'Sudadera deportiva con capucha, bolsillos frontales y material térmico para mayor comodidad',
                'price' => 749.00,
                'stock' => 28,
                'category_id' => $ropa->id,
                'tags' => [$oferta->id, $bestseller->id],
                'image_name' => 'sudadera.jpg',
                'image_url' => 'https://images.unsplash.com/photo-1590316519564-ebeeca222a95?q=80&w=500'
            ]
        ];

        foreach ($products as $productData) {
            $imagePath = $this->downloadAndSaveImage(
                $productData['image_url'],
                'products/' . $productData['image_name']
            );

            $product = Product::create([
                'name' => $productData['name'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'stock' => $productData['stock'],
                'image' => $imagePath,
                'slug' => Str::slug($productData['name']),
                'category_id' => $productData['category_id'],
                'active' => true,
                'currency' => self::CURRENCY,
            ]);

            $product->tags()->attach($productData['tags']);
        }
    }

    /**
     * Descarga una imagen desde URL y la guarda en storage
     */
    private function downloadAndSaveImage($url, $path)
    {
        try {
            $contents = file_get_contents($url);

            // La guardamos en storage/public/
            Storage::disk('public')->put($path, $contents);

            return $path;
        } catch (\Exception $e) {
            return null;
        }
    }
}
