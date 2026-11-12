<?php

namespace Database\Factories;

use App\Enums\StreamStatus;
use App\Models\Stream;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Stream>
 */
class StreamFactory extends Factory
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
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'video_id' => 'dQw4w9WgXcQ',
            'starts_at' => now()->startOfHour(),
            'status' => StreamStatus::Live,
        ];
    }

    /**
     * Indicate that the stream is a past recording.
     */
    public function past(): static
    {
        return $this->state(fn (array $attributes) => [
            'starts_at' => now()->subDays(3)->startOfDay()->addHours(10),
            'status' => StreamStatus::Past,
        ]);
    }

    /**
     * Indicate that visitors cannot post comments.
     */
    public function commentsDisabled(): static
    {
        return $this->state(fn (array $attributes) => [
            'comments_enabled' => false,
        ]);
    }

    /**
     * Indicate that existing comments are hidden under the video.
     */
    public function commentsHidden(): static
    {
        return $this->state(fn (array $attributes) => [
            'comments_visible' => false,
        ]);
    }
}
