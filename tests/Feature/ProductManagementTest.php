<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use Laravel\Sanctum\Sanctum;



class ProductManagementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testDeleteProduct()
    {
        Sanctum::actingAs(
        User::factory()->create(),
            ['*']);

        $this->withoutExceptionHandling();

        $product = Product::factory()->make();

        $this->delete("/api/products/delete/$product->id/");
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function testAddProduct()
    {
        $this->withoutExceptionHandling();

            Sanctum::actingAs(
                User::factory()->create(),
                ['*']
            );

        $product = Product::factory()->make();

        $response = $this->post('/api/products/add', [
            'descricao' => $product->descricao,
            'valor' => $product->valor,
            'quantidade' => $product->quantidade
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('products', [
            'descricao' => $product->descricao,
            'valor' => $product->valor,
            'quantidade' => $product->quantidade
        ]);
    }

    public function testGetProducts()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/products');

        $response->assertStatus(200);
    }

    public function testEditProduct()
    {
        Sanctum::actingAs(
    User::factory()->create(),
    ['*']
);

        $product = Product::factory()->create();
        $productEdit = Product::factory()->create();

        $response = $this->post("/api/products/update/{$product->id}", [
            'descricao' => $productEdit->descricao,
            'valor' => $productEdit->valor,
            'quantidade' => $productEdit->quantidade
        ]);

        $this->assertDatabaseHas('products', [
            'descricao' => $productEdit->descricao,
            'valor' => $productEdit->valor,
            'quantidade' => $productEdit->quantidade
        ]);
    }
}
