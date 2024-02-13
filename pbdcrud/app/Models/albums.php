<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class albums extends Model
{
    protected $table = 'albums';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'ID_Usuario',
        'Nome',
        'Duracao_Total',
    ];
    use HasFactory;
}
