<?php

namespace Database\Factories;

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
        return [
            'category_uuid' => fake()->uuid(),
            'uuid' => fake()->uuid(),
            'title' => fake()->sentence(4),
            'price' => fake()->randomFloat(2, 0, 100),
            'description' => fake()->paragraph(2),
            'metadata' => json_encode([
                'brand' => factory(BrandFactory::class)->create()->uuid,
                'image' => factory(FileFactory::class)->create()->uuid,
            ]),
        ];
    }
}
