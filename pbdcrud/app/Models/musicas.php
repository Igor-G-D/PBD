<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class musicas extends Model
{
    protected $table = 'musicas';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'ID_Album',
        'Nome',
        'Genero',
        'Duracao',
    ];
    use HasFactory;
}
