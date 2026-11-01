<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaylistFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'genre_id' => Genre::factory(),
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(1),
            'cover_image' => null,
            'is_public' => fake()->boolean(80),
        ];
    }
}
