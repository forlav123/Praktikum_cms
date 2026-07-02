<?php

namespace Tests\Feature;

use App\Http\Controllers\PublicController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_shop_page_limits_initial_products_for_faster_loading(): void
    {
        $category = Category::create(['name' => 'Elektronik', 'slug' => 'elektronik']);

        foreach (range(1, 15) as $index) {
            Product::create([
                'name' => 'Produk ' . $index,
                'slug' => 'produk-' . $index,
                'description' => 'Deskripsi produk ' . $index,
                'price' => 100000 + $index,
                'stock' => 10,
                'category_id' => $category->id,
                'is_active' => true,
            ]);
        }

        $view = (new PublicController())->shop();
        $productsJson = $view->getData()['productsJson'];

        $this->assertNotNull($productsJson);
        $this->assertLessThanOrEqual(12, $productsJson->count());
    }

    public function test_shop_products_endpoint_returns_paginated_results(): void
    {
        $category = Category::create(['name' => 'Elektronik', 'slug' => 'elektronik']);

        foreach (range(1, 15) as $index) {
            Product::create([
                'name' => 'Produk ' . $index,
                'slug' => 'produk-' . $index,
                'description' => 'Deskripsi produk ' . $index,
                'price' => 100000 + $index,
                'stock' => 10,
                'category_id' => $category->id,
                'is_active' => true,
            ]);
        }

        $response = $this->getJson(route('shop.products', ['page' => 1, 'per_page' => 6]));

        $response->assertOk()
            ->assertJsonPath('hasMore', true)
            ->assertJsonCount(6, 'products');
    }
}
