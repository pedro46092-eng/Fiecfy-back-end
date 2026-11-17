<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArtistRequest;
use App\Http\Resources\ArtistResource;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtistaController extends Controller
{
    public function index(Request $request)
    {
        $query = Artist::with('albums');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        return ArtistResource::collection($query->paginate(15));
    }

    public function store(StoreArtistRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('profile_pic')) {
            $path = $request->file('profile_pic')->store('artists', 'public');
            $data['profile_pic_url'] = Storage::url($path);
        }

        $artist = Artist::create($data);

        return (new ArtistResource($artist))
            ->additional(['message' => 'Artista cadastrado com sucesso!'])
            ->response()
            ->setStatusCode(201);
    }

    public function show($id)
    {
        $artist = Artist::with('albums')->findOrFail($id);

        return new ArtistResource($artist);
    }

    public function update(StoreArtistRequest $request, $id)
    {
        $artist = Artist::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('profile_pic')) {
            $path = $request->file('profile_pic')->store('artists', 'public');
            $data['profile_pic_url'] = Storage::url($path);
        }

        $artist->update($data);

        return (new ArtistResource($artist))
            ->additional(['message' => 'Artista atualizado com sucesso!']);
    }

    public function destroy($id)
    {
        $artist = Artist::findOrFail($id);
        $artist->delete();

        return response()->json([
            'message' => 'Artista removido com sucesso!'
        ], 200);
    }
}