<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;

class PlaylistController
{
    // Retorna APENAS as playlists do usuário logado (Pedro vê as dele, José vê as dele)
    public function index(Request $request)
    {
        $playlists = Playlist::where('user_id', $request->user()->id)
            ->with('songs')
            ->get();

        return response()->json($playlists, 200);
    }

    // Salva uma nova playlist vinculada automaticamente ao usuário logado
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'cover_url' => 'nullable|string',
        ]);

        // O Mutator no Model Playlist vai padronizar o 'title' antes de salvar
        $playlist = Playlist::create([
            'title' => $data['title'],
            'user_id' => $request->user()->id,
            'cover_url' => $data['cover_url'] ?? null,
        ]);

        return response()->json([
            'message' => 'Playlist criada com sucesso!',
            'data' => $playlist
        ], 201);
    }

    // Exibe os detalhes de uma playlist específica do usuário logado
    public function show(Request $request, int|string $id)
    {
        $playlist = Playlist::where('user_id', $request->user()->id)
            ->with('songs')
            ->findOrFail($id);

        return response()->json($playlist, 200);
    }

    // Exclusão Lógica (Soft Delete): preenche deleted_at
    public function destroy(Request $request, int|string $id)
    {
        $playlist = Playlist::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $playlist->delete();

        return response()->json([
            'message' => "Playlist com ID {$id} removida com sucesso!"
        ], 200);
    }

    // Restauração do Soft Delete: busca com withTrashed() e limpa deleted_at
    public function restore(Request $request, int|string $id)
    {
        $playlist = Playlist::withTrashed()
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        $playlist->restore();

        return response()->json([
            'message' => "Playlist com ID {$id} restaurada com sucesso!",
            'data' => $playlist
        ], 200);
    }

    // Anexa uma música à playlist do usuário logado
    public function addSong(Request $request, int|string $id)
    {
        $request->validate([
            'song_id' => 'required|exists:songs,id',
        ]);

        $playlist = Playlist::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $playlist->songs()->syncWithoutDetaching([$request->song_id]);

        return response()->json([
            'message' => 'Música adicionada à playlist com sucesso!',
            'data' => $playlist->load('songs')
        ], 200);
    }

    // Remove uma música da playlist do usuário logado
    public function removeSong(Request $request, int|string $id, int|string $songId)
    {
        $playlist = Playlist::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $playlist->songs()->detach($songId);

        return response()->json([
            'message' => 'Música removida da playlist com sucesso!'
        ], 200);
    }
}