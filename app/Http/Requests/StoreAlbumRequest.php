<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlbumRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'artist_id' => 'required|exists:artists,id',
            'title'     => 'required|string|max:255',
            'year'      => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'cover'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
}