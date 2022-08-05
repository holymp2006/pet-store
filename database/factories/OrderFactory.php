<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomFloat(2, 0, 100),
            'address' => [
                'billing' => $this->faker->streetAddress(),
                'shipping' => $this->faker->streetAddress(),
            ],
            'delivery_fee' => 10.00,
        ];
    }
}
