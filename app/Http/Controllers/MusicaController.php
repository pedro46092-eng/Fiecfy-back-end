<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MusicaController
{
    public function index()
    {
        $musicas = [
            ['id' => 1, 'titulo' => 'Blinding Lights', 'duracao' => '3:20'],
            ['id' => 2, 'titulo' => 'Get Lucky', 'duracao' => '4:08'],
            ['id' => 3, 'titulo' => 'Bohemian Rhapsody', 'duracao' => '5:55']
        ];

        return response()->json([
            'sucesso' => true,
            'dados' => $musicas
        ], 200);
    }
}