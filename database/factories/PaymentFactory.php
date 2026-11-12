<?php

namespace Database\Factories;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Payment;
use App\Models\PaymentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'payment_type_id' => PaymentType::factory(),
            'method' => PaymentMethod::MtnMobileMoney,
            'amount' => fake()->numberBetween(1, 100) * 1000,
            'currency' => 'UGX',
            'payer_name' => fake()->name(),
            'phone' => '2567'.fake()->numerify('########'),
            'note' => null,
            'status' => PaymentStatus::Pending,
            'provider_reference' => null,
            'paid_at' => null,
        ];
    }

    /**
     * Indicate that the payment went through.
     */
    public function successful(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PaymentStatus::Successful,
            'provider_reference' => fake()->uuid(),
            'paid_at' => now(),
        ]);
    }
}
