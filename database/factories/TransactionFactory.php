<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'merchant_id' => null,
            'reference_id' => fake()->uuid(),
            'amount' => fake()->numberBetween(100, 500),
            'channel' => 'online',
            'customer_name' => fake()->name(),
            'customer_email' => fake()->email(),
            'customer_phone_number' => fake()->phoneNumber(),
            'payment_page_id' => '753a4bdf-04f8-466a-b973-2e4a01864487',
            'status' => fake()->randomElement(['success', 'pending', 'fail', 'initiated']),
            'created_at' => fake()->dateTimeBetween('-2 years'),
            'updated_at' => function (array $attributes) {
                return fake()->dateTimeBetween($attributes['created_at']);
            },
        ];
    }
}
