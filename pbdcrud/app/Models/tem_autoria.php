<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tem_autoria extends Model
{
    protected $table = 'tem_autoria';
    public $timestamps = false;
    protected $primaryKey = ['id_musica', 'id_usuario'];
    protected $fillable = [
        'ID_Musica',
        'ID_Usuario',
    ];
    use HasFactory;
}
