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
        $session_id = Session::get('login');
        $playlist = DB::table('playlists')->where('id_usuario','=',Session::get('login'))->where('nome','=','Músicas Curtidas')->first();
        $playlist_musicas_curtidas = $playlist->id;
        $duracaoPlaylistDB = $playlist->duracao;
        $duracaoMusicaDB = DB::table('musicas')->where('id','=',$musica_id)->first()->duracao;
        $Mseg = $Mmin =  $Mhour = $Pseg = $Pmin = $Phour = 0 ;
        list($Mhour, $Mmin, $Mseg) = sscanf($duracaoMusicaDB,'%d:%d:%d');
        list($Phour, $Pmin, $Pseg) = sscanf($duracaoPlaylistDB,'%d:%d:%d');
        $duracaoMusicaSeg = $Mhour * 3600 + $Mmin * 60 + $Mseg;
        $duracaoPlaylistSeg = $Phour * 3600 + $Pmin * 60 + $Pseg;

        $novaDuracaoPlaylist = gmdate("H:i:s", $duracaoPlaylistSeg + $duracaoMusicaSeg);

        DB::transaction(function () use ($musica_id, $session_id, $playlist_musicas_curtidas, $novaDuracaoPlaylist) {
            DB::table('curte_musicas')
                ->where('id_musica','=',$musica_id)
                ->where('id_usuario','=', $session_id)
                ->delete();

            DB::table('playlist_possui_musicas')
                ->where('id_musica','=',$musica_id)
                ->where('id_playlist','=', $playlist_musicas_curtidas)
                ->delete();

            DB::table('playlists')->where('id','=',$playlist_musicas_curtidas)->update(['duracao' => $novaDuracaoPlaylist]);

        });
    }

    public static function like(Request $request)
    {

        $id_musica = $request->id;
        $id_usuario = Session::get('login');
        $playlist = DB::table('playlists')->where('id_usuario','=',Session::get('login'))->where('nome','=','Músicas Curtidas')->first();
        $playlist_musicas_curtidas = $playlist->id;
        $duracaoPlaylistDB = $playlist->duracao;
        $duracaoMusicaDB = DB::table('musicas')->where('id','=',$id_musica)->first()->duracao;
        $Mseg = $Mmin =  $Mhour = $Pseg = $Pmin = $Phour = 0 ;
        list($Mhour, $Mmin, $Mseg) = sscanf($duracaoMusicaDB,'%d:%d:%d');
        list($Phour, $Pmin, $Pseg) = sscanf($duracaoPlaylistDB,'%d:%d:%d');
        $duracaoMusicaSeg = $Mhour * 3600 + $Mmin * 60 + $Mseg;
        $duracaoPlaylistSeg = $Phour * 3600 + $Pmin * 60 + $Pseg;

        $novaDuracaoPlaylist = gmdate("H:i:s", $duracaoPlaylistSeg + $duracaoMusicaSeg);

        DB::transaction(function () use ($id_musica, $id_usuario,$playlist_musicas_curtidas, $novaDuracaoPlaylist) {
            DB::table('curte_musicas')->insert([
                'id_usuario' => $id_usuario,
                'id_musica' => $id_musica,
            ]);

            DB::table('playlist_possui_musicas')->insert([
                'id_playlist' => $playlist_musicas_curtidas,
                'id_musica' => $id_musica,
            ]);

            DB::table('playlists')->where('id','=',$playlist_musicas_curtidas)->update(['duracao' => $novaDuracaoPlaylist]);
        });
    }
}
