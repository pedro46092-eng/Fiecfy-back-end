<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;

class PlaylistController
{
    // Retorna todas as playlists do banco
    public function index()
    {
        return response()->json(Playlist::with('songs')->get(), 200);
    }

    // Salva uma nova playlist no banco de dados
    public function store(Request $request)
    {
        $playlist = Playlist::create($request->all());

        return response()->json([
            'message' => 'Playlist criada com sucesso!',
            'data' => $playlist
        ], 201);
    }

    // Remove uma playlist do banco
    public function destroy($id)
    {
        $playlist = Playlist::findOrFail($id);
        $playlist->delete();

        return response()->json([
            'message' => "Playlist com ID {$id} removida com sucesso!"
        ], 200);
    }

    // Exercício 6: Anexa uma música à playlist
    public function addSong(Request $request, $id)
    {
        $request->validate([
            'song_id' => 'required|exists:songs,id',
        ]);

        $playlist = Playlist::findOrFail($id);
        $playlist->songs()->attach($request->song_id);

        return response()->json([
            'message' => 'Música adicionada à playlist com sucesso!'
        ], 200);
    }
}