<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlaylistRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'type'  => 'nullable|in:public,private',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
}