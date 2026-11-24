<?php

namespace Database\Factories;

use App\Models\Ministry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ministry>
 */
class MinistryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = ucfirst(fake()->unique()->word()).' Ministry';

        return [
            'name' => $name,
            'slug' => str($name)->slug()->toString(),
            'summary' => fake()->sentence(),
            'description' => fake()->paragraphs(2, true),
            'leader' => fake()->name(),
            'meeting_time' => 'Saturdays 3:00 PM',
            'sort_order' => 100,
            'published_at' => now()->subDay(),
        ];
    }

    /**
     * Indicate that the ministry is hidden from the public site.
     */
    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'published_at' => null,
        ]);
    }
}
