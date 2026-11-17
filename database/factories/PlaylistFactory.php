<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaylistFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'   => User::factory(),
            'title'     => fake()->words(2, true),
            'type'      => fake()->randomElement(['public', 'private']),
            'cover_url' => fake()->imageUrl(640, 640, 'abstract', true),
        ];
    }
}