<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class curte_musicas extends Model
{
    protected $table = 'curte_musicas';
    public $timestamps = false;
    protected $fillable = [
        'ID_Usuario',
        'ID_Musica',
    ];
    use HasFactory;
}
