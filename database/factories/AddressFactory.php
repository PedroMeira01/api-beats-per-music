<?php

namespace Database\Factories;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'addressable_id' => null,
            'addressable_type' => null,
            'street' => fake()->streetName(),
            'city' => fake()->city(),
            'zip_code' => fake()->postcode(),
        ];
    }

    public function forUser()
    {
        return $this->state(function(array $attributes) {
            return [
                'addressable_id' => User::factory(),
                'addressable_type' => User::class,
            ];
        });
    }

    public function forStore()
    {
        return $this->state(function(array $attributes) {
            return [
                'addressable_id' => Store::factory(),
                'addressable_type' => Store::class,
            ];
        });
    }
}
