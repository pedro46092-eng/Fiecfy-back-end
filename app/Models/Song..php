<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Song extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'album_id',
        'title',
        'duration',
        'audio_url',
    ];

    protected $casts = [
        'duration' => 'integer',
    ];

    // Faz o accessor duration_formatted aparecer automaticamente no JSON da API
    protected $appends = ['duration_formatted'];

    // Mutator: limpa espaços e capitaliza respeitando acentos (UTF-8) antes de salvar
    protected function title(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => mb_convert_case(trim($value), MB_CASE_TITLE, 'UTF-8'),
        );
    }

    // Accessor: converte os segundos salvos no banco para o formato "03:35" na saída
    protected function durationFormatted(): Attribute
    {
        return Attribute::make(
            get: function () {
                $totalSeconds = (int) ($this->duration ?? 0);
                $minutes = floor($totalSeconds / 60);
                $seconds = $totalSeconds % 60;
                return sprintf('%02d:%02d', $minutes, $seconds);
            }
        );
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_song');
    }
}