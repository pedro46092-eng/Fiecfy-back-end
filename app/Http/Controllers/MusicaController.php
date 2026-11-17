<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSongRequest;
use App\Http\Resources\SongResource;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MusicaController extends Controller
{
    public function index(Request $request)
    {
        $query = Song::with('album');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        return SongResource::collection($query->paginate(15));
    }

    public function store(StoreSongRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('audio')) {
            $path = $request->file('audio')->store('songs', 'public');
            $data['audio_url'] = Storage::url($path);
        }

        $song = Song::create($data);

        return (new SongResource($song->load('album')))
            ->additional(['message' => 'Música cadastrada com sucesso!'])
            ->response()
            ->setStatusCode(201);
    }

    public function show($id)
    {
        $song = Song::with('album')->findOrFail($id);

        return new SongResource($song);
    }

    public function update(StoreSongRequest $request, $id)
    {
        $song = Song::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('audio')) {
            $path = $request->file('audio')->store('songs', 'public');
            $data['audio_url'] = Storage::url($path);
        }

        $song->update($data);

        return (new SongResource($song->load('album')))
            ->additional(['message' => 'Música atualizada com sucesso!']);
    }

    public function destroy(int|string $id)
    {
        $song = Song::findOrFail($id);
        $song->delete();

        return response()->json([
            'message' => 'Música excluída com sucesso!'
        ], 200);
    }

    public function restore(int|string $id)
    {
        $song = Song::withTrashed()->findOrFail($id);
        $song->restore();

        return (new SongResource($song))
            ->additional(['message' => 'Música restaurada com sucesso!']);
    }
}