<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class curte_albums extends Model
{
    protected $table = 'curte_albums';
    protected $primaryKey = ['id_album', 'id_usuario'];
    public $timestamps = false;
    protected $fillable = [
        'ID_Usuario',
        'ID_Album',
    ];
    use HasFactory;
}
