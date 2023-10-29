<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Enums\PaymentTypes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'status' => OrderStatus::PENDING_PAYMENT,
            'payment_type' => (fake()->randomElement(PaymentTypes::cases()))->value,
            'total_order' => fake()->randomNumber(),
            'tracking_code' => fake()->shuffle('TRACKINGCODE'),
            'delivery_address_id' => 1,
        ];
    }
}
