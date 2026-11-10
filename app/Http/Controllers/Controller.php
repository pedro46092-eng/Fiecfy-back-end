<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlaylistController
{
    public function index()
    {
        return response()->json([
            'message' => 'Listagem de playlists retornada com sucesso',
            'data' => [
                ['id' => 1, 'nome_playlist' => 'Rock Classics'],
                ['id' => 2, 'nome_playlist' => 'Lofi Beats']
            ]
        ], 200);
    }
}