<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_expected_fillable_attributes()
    {
        $product = new Product();

        $this->assertEquals([
            'name',
            'description',
            'price',
            'stock',
            'image',
            'slug',
            'category_id',
            'active'
        ], $product->getFillable());
    }

    /** @test */
    public function it_belongs_to_a_category()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $product->category);
        $this->assertEquals($category->id, $product->category->id);
    }

    /** @test */
    public function it_can_have_many_tags()
    {
        $product = Product::factory()->create();
        $tags = Tag::factory(3)->create();

        $product->tags()->attach($tags->pluck('id'));

        $this->assertCount(3, $product->tags);
        $this->assertInstanceOf(Tag::class, $product->tags->first());
    }

    /** @test */
    public function it_can_determine_if_it_has_image()
    {
        $productWithImage = Product::factory()->create(['image' => 'products/image.jpg']);
        $productWithoutImage = Product::factory()->create(['image' => null]);

        $this->assertTrue(!empty($productWithImage->image));
        $this->assertTrue(empty($productWithoutImage->image));
    }
}
