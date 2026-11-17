<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlbumRequest;
use App\Http\Resources\AlbumResource;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function index(Request $request)
    {
        $query = Album::with(['artist', 'songs']);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        return AlbumResource::collection($query->paginate(15));
    }

    public function store(StoreAlbumRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('covers/albums', 'public');
            $data['cover_url'] = Storage::url($path);
        }

        $album = Album::create($data);

        return (new AlbumResource($album->load('artist')))
            ->additional(['message' => 'Álbum criado com sucesso!'])
            ->response()
            ->setStatusCode(201);
    }

    public function show($id)
    {
        $album = Album::with(['artist', 'songs'])->findOrFail($id);

        return new AlbumResource($album);
    }

    public function update(StoreAlbumRequest $request, $id)
    {
        $album = Album::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('covers/albums', 'public');
            $data['cover_url'] = Storage::url($path);
        }

        $album->update($data);

        return (new AlbumResource($album->load('artist')))
            ->additional(['message' => 'Álbum atualizado com sucesso!']);
    }

    public function destroy($id)
    {
        $album = Album::findOrFail($id);
        $album->delete();

        return response()->json([
            'message' => 'Álbum removido com sucesso!'
        ], 200);
    }
}