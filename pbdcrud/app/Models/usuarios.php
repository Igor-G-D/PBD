<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usuarios extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'CPF',
        'ID_Distribuidor',
        'Nome',
        'Senha',
    ];
    use HasFactory;
}
