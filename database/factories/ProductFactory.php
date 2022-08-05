<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\File;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();
        $file = File::factory()->create();
        return [
            'category_id' => $category->id,
            'uuid' => $this->faker->uuid(),
            'title' => $this->faker->sentence(4),
            'price' => $this->faker->randomFloat(2, 0, 100),
            'description' => $this->faker->paragraph(2),
            'metadata' => [
                'brand' => $brand->uuid,
                'image' => $file->uuid,
            ],
        ];
    }
}
