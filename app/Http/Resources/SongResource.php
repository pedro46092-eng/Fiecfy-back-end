<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SongResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                 => $this->id,
            'title'              => $this->title,
            'duration'           => $this->duration,
            'duration_formatted' => $this->duration_formatted, // Usa o Accessor do Model
            'audio_url'          => $this->audio_url,
            'album'              => new AlbumResource($this->whenLoaded('album')),
        ];
    }
}