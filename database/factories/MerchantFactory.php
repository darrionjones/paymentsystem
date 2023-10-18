<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Merchant>
 */
class MerchantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'business_name' => fake()->sentence(1),
            'address' => fake()->address(),
            'region' => fake()->sentence(1),
            'digital_address' => fake()->address(),
            'business_email' => fake()->email(),
            'contact_person_name' => fake()->name(),
            'contact_person_email' => fake()->email(),
            'contact_person_phone' => fake()->phoneNumber(),
            'client_id' => Str::random(16),
            'client_secret' => Str::random(16),
        ];
    }
}
