<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $response = $this->get('/admin/products');

        $response->assertStatus(200);
        $response->assertViewIs('admin.products.index');
    }

    public function testCreate()
    {
        $response = $this->get('/admin/products/create');

        $response->assertStatus(200);
        $response->assertViewIs('admin.products.create');
    }

    public function testStore()
    {
        $product = Product::factory()->make();

        $response = $this->post('/admin/products', $product->toArray());

        $response->assertStatus(302);
        $response->assertRedirect('/admin/products');

        $this->assertDatabaseHas('products', $product->toArray());
    }

    public function testEdit()
    {
        $product = Product::factory()->create();

        $response = $this->get('/admin/products/' . $product->id . '/edit');

        $response->assertStatus(200);
        $response->assertViewIs('admin.products.edit');
        $response->assertSee($product->name);
    }

    public function testUpdate()
    {
        $product = Product::factory()->create();

        $updatedProduct = [
            'name' => 'Updated Product',
            'description' => 'Updated Description',
            'price' => 100,
            'stock_quantity' => 50,
        ];

        $response = $this->put('/admin/products/' . $product->id, $updatedProduct);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/products');

        $this->assertDatabaseHas('products', $updatedProduct);
    }

    public function testShow()
    {
        $product = Product::factory()->create();

        $response = $this->get('/admin/products/' . $product->id);

        $response->assertStatus(200);
        $response->assertViewIs('admin.products.details');
        $response->assertSee($product->name);
    }

    public function testDestroy()
    {
        $product = Product::factory()->create();

        $response = $this->delete('/admin/products/' . $product->id);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/products');

        $this->assertDatabaseMissing('products', $product->toArray());
    }
}