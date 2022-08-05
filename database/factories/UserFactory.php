<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'a-new-password', // password
            'address' => $this->faker->streetAddress(),
            'phone_number' => $this->faker->phoneNumber(),
            'email_verified_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified(): static
    {
        return $this->state(function (array $attributes): array {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
