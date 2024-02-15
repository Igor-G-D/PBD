<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class curte_musicas extends Model
{
    protected $table = 'curte_musicas';
    protected $primaryKey = ['id_musica', 'id_usuario'];
    public $timestamps = false;
    protected $fillable = [
        'id_usuario',
        'id_musica',
    ];
    use HasFactory;
}
