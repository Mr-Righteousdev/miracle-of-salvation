<?php

namespace Database\Factories;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Branch>
 */
class BranchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $city = fake()->unique()->city();

        return [
            'name' => 'Miracle of Salvation '.$city,
            'slug' => str($city)->slug()->toString(),
            'location' => $city.', '.fake()->country(),
            'description' => fake()->sentence(),
            'pastor' => 'Pastor '.fake()->name(),
            'phone' => fake()->phoneNumber(),
            'service_times' => 'Sundays 9:00 AM',
            'sort_order' => 100,
            'published_at' => now()->subDay(),
        ];
    }

    /**
     * Indicate that the branch is hidden from the public site.
     */
    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'published_at' => null,
        ]);
    }
}
