<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement([
                'credit_card',
                'cash_on_delivery',
                'bank_transfer'
            ]),
            'details' => []
        ];
    }
}
