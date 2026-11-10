<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'genre', 'profile_pic_url'];

    public function albums()
    {
        return $this->hasMany(Album::class);
    }
}
