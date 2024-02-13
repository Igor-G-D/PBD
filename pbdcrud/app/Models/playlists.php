<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class playlists extends Model
{
    protected $table = 'playlists';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'ID_Usuario',
        'Nome',
        'Descricao',
        'Indicador_Privado',
        'Duracao_Total',
    ];
    use HasFactory;
}
