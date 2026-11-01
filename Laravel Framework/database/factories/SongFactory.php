<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SongFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => fake()->sentence(3),
            'artist' => fake()->name(),
            'album' => fake()->words(2, true),
            'duration_seconds' => fake()->numberBetween(120, 360),
            'audio_file' => null,
        ];
    }
}
