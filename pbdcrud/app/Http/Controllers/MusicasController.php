<?php

namespace App\Http\Controllers;

use App\Models\usuarios;
use App\Models\playlists;
use App\Models\curte_musicas;
use App\Http\Controllers\AlbumsController;
use App\Http\Controllers\PlaylistsController;
use DateInterval;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MusicasController extends Controller
{
    public static function unlike(Request $request)
    {
        $musica_id = $request->id;

        $session_id = SESSION::get('login');

        DB::table('curte_musicas')
            ->where('id_musica','=',$musica_id)
            ->where('id_usuario','=', $session_id)
            ->delete();
    }

    public static function like(Request $request)
    {

        $id_musica = $request->id;
        $id_usuario = Session::get('login');

        DB::table('curte_musicas')->insert([
            'id_usuario' => $id_usuario,
            'id_musica' => $id_musica,
        ]);
    }
}
