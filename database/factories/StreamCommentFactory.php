<?php

namespace Database\Factories;

use App\Models\Stream;
use App\Models\StreamComment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StreamComment>
 */
class StreamCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'stream_id' => Stream::factory(),
            'name' => fake()->firstName(),
            'message' => fake()->sentence(),
            'is_approved' => true,
        ];
    }

    /**
     * Indicate that the comment is awaiting moderation.
     */
    public function unapproved(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_approved' => false,
        ]);
    }
}
