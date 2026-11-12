<?php

namespace Database\Factories;

use App\Models\PrayerRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PrayerRequest>
 */
class PrayerRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'message' => fake()->paragraph(),
            'is_prayed_for' => false,
        ];
    }

    /**
     * Indicate that the request has been prayed for.
     */
    public function prayedFor(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_prayed_for' => true,
        ]);
    }
}
