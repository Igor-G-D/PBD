<?php

namespace App\Http\Controllers;

use App\Models\usuarios;
use App\Models\playlists;
use App\Http\Controllers\AlbumsController;
use App\Http\Controllers\PlaylistsController;
use DateInterval;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BuscaController extends Controller
{
    public static function show()
    {
        return view("search");
    }
}
