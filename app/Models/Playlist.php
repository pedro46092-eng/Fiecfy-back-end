<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Playlist extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'type',
        'cover_url',
    ];

    // Mutator: padroniza o título da playlist antes de salvar no banco
    protected function title(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => ucwords(strtolower(trim($value))),
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function songs()
    {
        return $this->belongsToMany(Song::class, 'playlist_song');
    }
}