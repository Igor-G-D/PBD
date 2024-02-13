<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class playlist_possui_musicas extends Model
{
    protected $table = 'playlist_possui_musicas';
    public $timestamps = false;
    protected $fillable = [
        'ID_Playlist',
        'ID_Musica',
    ];
    use HasFactory;
}
