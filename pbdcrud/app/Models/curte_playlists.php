<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class curte_playlists extends Model
{
    protected $table = 'curte_playlists';
    public $timestamps = false;
    protected $fillable = [
        'ID_Playlist',
        'ID_Usuario',
    ];
    use HasFactory;
}
