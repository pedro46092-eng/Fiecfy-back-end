<?php

namespace Database\Factories;

use App\Models\Album;
use Illuminate\Database\Eloquent\Factories\Factory;

class SongFactory extends Factory
{
    public function definition(): array
    {
        return [
            'album_id'  => Album::factory(),
            'title'     => fake()->sentence(3),
            'duration'  => fake()->numberBetween(120, 320), // Entre 2:00 e 5:20
            'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3',
        ];
    }
}