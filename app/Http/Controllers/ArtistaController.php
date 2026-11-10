<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArtistaController
{
    // Método index: Devolve a coleção inteira
    public function index()
    {
        $colecaoArtistas = [
            ['nome' => 'The Weeknd', 'estilo' => 'R&B / Pop'],
            ['nome' => 'Daft Punk', 'estilo' => 'Eletrônica Clássica']
        ];

        return response()->json([
            'sucesso' => true,
            'dados' => $colecaoArtistas
        ]);
    }

    // Método show: Devolve um artista pelo ID
    public function show($id)
    {
        return response()->json([
            'sucesso' => true,
            'mensagem' => "Log de Busca ativado para o ID de Artista " . $id
        ]);
    }
}