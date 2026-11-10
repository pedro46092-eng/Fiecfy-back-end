<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController
{
    // Exercício 3: Retorna todos os álbuns
    public function index()
    {
        return response()->json(Album::all(), 200);
    }

    // Método de Criação
    public function store(Request $request)
    {
        $album = Album::create($request->all());

        return response()->json($album, 201);
    }

    // Exercício 3: Busca o álbum pelo ID trazendo as músicas associadas (Eager Loading)
    public function show($id)
    {
        $album = Album::with('songs')->findOrFail($id);

        return response()->json($album, 200);
    }

    // Exercício 4: Atualiza um álbum
    public function update(Request $request, $id)
    {
        $album = Album::findOrFail($id);
        $album->update($request->all());

        return response()->json($album, 200);
    }

    // Exercício 5: Deleta um álbum
    public function destroy($id)
    {
        $album = Album::findOrFail($id);
        $album->delete();

        return response()->json([
            'message' => 'Álbum removido com sucesso!'
        ], 200);
    }
}