<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSongRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'album_id' => 'nullable|exists:albums,id',
            'title'    => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'audio'    => 'nullable|file|mimes:mp3,wav,ogg|max:15360', // até 15MB
        ];
    }
}