<?php

namespace Database\Factories;

use App\Models\Stream;
use App\Models\StreamLike;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StreamLike>
 */
class StreamLikeFactory extends Factory
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
            'liker_token' => fake()->uuid(),
        ];
    }
}
