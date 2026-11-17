<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArtistRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'genre'       => 'nullable|string|max:100',
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
}