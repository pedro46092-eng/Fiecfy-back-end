<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArtistResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'genre'           => $this->genre,
            'profile_pic_url' => $this->profile_pic_url,
            'albums'          => AlbumResource::collection($this->whenLoaded('albums')),
        ];
    }
}