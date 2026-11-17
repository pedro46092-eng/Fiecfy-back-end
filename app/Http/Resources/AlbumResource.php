<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'year'      => $this->year,
            'cover_url' => $this->cover_url,
            'artist'    => new ArtistResource($this->whenLoaded('artist')),
            'songs'     => SongResource::collection($this->whenLoaded('songs')),
        ];
    }
}