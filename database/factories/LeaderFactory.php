<?php

namespace Database\Factories;

use App\Models\Leader;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Leader>
 */
class LeaderFactory extends Factory
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
            'role' => fake()->randomElement(['Senior Pastor', 'Associate Pastor', 'Church Elder', 'Deacon']),
            'bio' => fake()->paragraph(),
            'sort_order' => 0,
            'published_at' => now()->subDay(),
        ];
    }

    /**
     * Indicate that the leader is hidden from the public site.
     */
    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'published_at' => null,
        ]);
    }
}
