<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Playlist;
use App\Models\Song;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seu usuário fixo para testes
        $user = User::create([
            'name'     => 'Pedro Henrique',
            'email'    => 'adm@fiecfy.com',
            'password' => Hash::make('adm@271221'),
        ]);

        // 2. Seus artistas reais em destaque
        $artists = ['Gusttavo Lima', 'Ana Castela', 'Luan Santana', 'Jorge & Mateus'];

        foreach ($artists as $artistName) {
            $artist = Artist::create([
                'name'            => $artistName,
                'genre'           => 'Sertanejo',
                'profile_pic_url' => 'https://i.pravatar.cc/400',
            ]);

            $album = Album::create([
                'artist_id' => $artist->id,
                'title'     => 'Álbum ' . $artistName,
                'year'      => 2026,
                'cover_url' => 'https://picsum.photos/640/640',
            ]);

            Song::create([
                'album_id'  => $album->id,
                'title'     => 'Música Sucesso ' . $artistName,
                'duration'  => 187,
                'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3',
            ]);
        }

        // Corrigido de 'name' para 'title'
        $playlist = Playlist::create([
            'title'   => 'Minhas Curtidas',
            'user_id' => $user->id,
        ]);

        $playlist->songs()->attach(Song::pluck('id')->toArray());

        // 3. Dados simulados via Factories + FakerPHP (exigido na rubrica + testa paginação)
        $extraUsers = User::factory(4)->create();

        Artist::factory(6)->create()->each(function ($artist) {
            Album::factory(2)->create(['artist_id' => $artist->id])->each(function ($album) {
                Song::factory(4)->create(['album_id' => $album->id]);
            });
        });

        $allSongs = Song::all();
        Playlist::factory(8)->make()->each(function ($pl) use ($extraUsers, $allSongs) {
            $pl->user_id = $extraUsers->random()->id;
            $pl->save();
            $pl->songs()->attach($allSongs->random(5)->pluck('id'));
        });
    }
}