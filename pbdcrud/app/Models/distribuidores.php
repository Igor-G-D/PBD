<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class distribuidores extends Model
{
    protected $table = 'distribuidores';
    protected $primaryKey = 'id';

    public $timestamps = false;
    protected $fillable = [
        'CNPJ',
        'Senha',
        'Nome',
    ];
    use HasFactory;
}
