<?php

namespace Tests\Feature;

use App\Enums\Role;
use Tests\TestCase;
use App\Models\File;
use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Arr;
use App\Services\JwtTokenService;

class ProductTest extends TestCase
{
    /** @test */
    public function user_can_view_all_products()
    {
        $products = Product::factory(5)->create();
        $response = $this->getJson('api/v1/products');
        $product = $products->first();
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid' => $product->uuid,
                        'title' => $product->title,
                        'price' => $product->price,
                        'description' => $product->description,
                        'created_at' => $product->created_at->toDateTimeString(),
                    ]
                ]

            ]);
    }
    /** @test */
    public function user_can_view_a_product()
    {
        $product = Product::factory()->create();
        $response = $this->getJson('api/v1/product/' . $product->uuid);
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'uuid' => $product->uuid,
                    'title' => $product->title,
                    'price' => $product->price,
                    'description' => $product->description,
                    'created_at' => $product->created_at->toDateTimeString(),
                ]
            ]);
    }
    /** @test */
    public function admin_can_create_a_product()
    {
        $user = User::factory()->create([
            'is_admin' => Role::ADMIN,
        ]);
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
        $token = (new JwtTokenService)->createTokenForUser($user);
        $response = $this->withToken($token)
            ->postJson('api/v1/product/create', $data);
        $response->assertSuccessful();
        $this->assertDatabaseHas('products', Arr::only($data, ['title', 'price', 'description']));
        $response->assertJson(['data' => $data]);
    }
    /** @test */
    public function admin_can_update_a_product()
    {
        $user = User::factory()->create([
            'is_admin' => Role::ADMIN,
        ]);
        $product = Product::factory()->create();
        $category = Category::factory()->create();
        $data = [
            'category_uuid' => $category->uuid,
            'title' => 'Updated Product title',
            'price' => 10.45,
            'description' => 'This is an updated product',
            'metadata' => [
                'brand' =>  $product->metadata['brand'],
                'image' =>  $product->metadata['image'],
            ],
        ];
        $now = now();
        $token = (new JwtTokenService)->createTokenForUser($user);
        $response = $this->withToken($token)
            ->putJson('api/v1/product/' . $product->uuid, $data);
        $response->assertSuccessful();
        $this->assertDatabaseHas('products', Arr::only($data, ['title', 'price', 'description']));
        $response->assertJson([
            'data' => [
                'uuid' => $product->uuid,
                'title' => $data['title'],
                'price' => $data['price'],
                'description' => $data['description'],
                'updated_at' => $now->toDateTimeString(),
            ]
        ]);
    }
}
