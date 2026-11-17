<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArtistFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'            => fake()->name(),
            'genre'           => fake()->randomElement(['Pop', 'Rock', 'R&B', 'Eletrônica', 'Hip-Hop', 'MPB', 'Sertanejo', 'Jazz']),
            'profile_pic_url' => fake()->imageUrl(400, 400, 'people', true),
        ];
    }
}