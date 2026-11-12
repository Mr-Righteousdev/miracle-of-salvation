<?php

namespace Database\Factories;

use App\Enums\EventCategory;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(2),
            'starts_at' => now()->addWeek()->startOfDay()->addHours(10),
            'location' => fake()->streetAddress(),
            'category' => EventCategory::ChurchProgram,
            'image' => null,
        ];
    }

    /**
     * Indicate that the event started two months ago.
     */
    public function past(): static
    {
        return $this->state(fn (array $attributes) => [
            'starts_at' => now()->subMonths(2)->startOfDay()->addHours(10),
        ]);
    }

    /**
     * Put the event in the given category.
     */
    public function category(EventCategory $category): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => $category,
        ]);
    }
}
