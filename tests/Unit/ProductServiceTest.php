<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\File;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Services\ProductService;
use Database\Factories\FileFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_creates_a_product_in_database()
    {
        $this->withoutExceptionHandling();

        // arrange
        $service = new ProductService();
        $brand = Brand::factory()->create();
        $file = File::factory()->create();
        $category = Category::factory()->create();
        $data = [
            'category_uuid' => $category->uuid,
            'title' => 'Test Product',
            'price' => 10.45,
            'description' => 'This is a test product',
            'metadata' => json_encode([
                'brand' => $brand->uuid,
                'image' => $file->uuid,
            ]),
        ];
        // act
        $product = $service->create($data);

        // assert
        $this->assertInstanceOf(Product::class, $product);
    }
}
