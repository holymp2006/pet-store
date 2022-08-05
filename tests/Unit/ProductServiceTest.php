<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\File;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Services\ProductService;

class ProductServiceTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates_a_product_in_database()
    {
        $this->withoutExceptionHandling();

        $service = new ProductService();
        $brand = Brand::factory()->create();
        $file = File::factory()->create();
        $category = Category::factory()->create();
        $data = [
            'category_uuid' => $category->uuid,
            'title' => 'Test Product',
            'price' => 10.45,
            'description' => 'This is a test product',
            'metadata' => [
                'brand' => $brand->uuid,
                'image' => $file->uuid,
            ],
        ];
        $product = $service->create($data);

        $this->assertInstanceOf(Product::class, $product);
    }
}
