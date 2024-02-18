<?php

namespace App\Http\Controllers;

use App\Models\usuarios;
use App\Models\playlists;
use App\Models\curte_playlists;
use DateInterval;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PlaylistsController extends Controller
{
    public static function show()
    {
        $userSession = Session::get('login');
        if($userSession == null) {
            return redirect('/');
        }

        $userPlaylists = DB::table('playlists')->where('id_usuario', $userSession)->get();
        $likedPlaylists = DB::table('playlists')
        ->join('curte_playlists', 'playlists.id', '=', 'curte_playlists.id_playlist')
        ->where('curte_playlists.id_usuario', '=', $userSession)
        ->select('playlists.*')
        ->get();
        return view("playlists.playlistsDashboard", compact('userPlaylists','likedPlaylists'));
    }

    public static function delete(Request $request)
    {
        $playlist_id = $request->playlist;

        $playlistOwner = DB::table('playlists')->where('id','=',$playlist_id)->first()->id_usuario;

        if(SESSION::get('login') != $playlistOwner) {
            return redirect('/playlists')->with('error','Você não é o dono desta playlist!');
        }
        DB::transaction(function () use ($playlist_id) {
            DB::table('curte_playlists')->where('id_playlist', '=', $playlist_id)->delete();
            DB::table('playlist_possui_musicas')->where('id_playlist', '=', $playlist_id)->delete();
            DB::table('playlists')->where('id', '=', $playlist_id)->delete();
        });
        return redirect('/playlists');
    }

    public static function unlike(Request $request)
    {
        $playlist_id = $request->id;

        $session_id = SESSION::get('login');

        DB::table('curte_playlists')
            ->where('id_playlist','=',$playlist_id)
            ->where('id_usuario','=', $session_id)
            ->delete();
    }

    public static function like(Request $request)
    {

        $id_playlist = $request->id;
        $id_usuario = Session::get('login');

        DB::table('curte_playlists')->insert([
            'id_usuario' => $id_usuario,
            'id_playlist' => $id_playlist,
        ]);
    }

    public static function details($playlist_id) {
        $playlist = DB::table('playlists')->where('id', $playlist_id)->first();
        if($playlist->indicador_privado == true && $playlist->id_usuario != Session::get('login')){
            return redirect('/playlists')->with('error', 'Playlist privada!');
        }

        $musicas = DB::table('musicas')
        ->leftJoin('playlist_possui_musicas', 'musicas.id', '=', 'playlist_possui_musicas.id_musica')
        ->where('playlist_possui_musicas.id_playlist', '=', $playlist->id)
        ->select('musicas.*')
        ->get();
        return view('playlists.playlistsDetails',compact('playlist', 'musicas'));
    }

    public static function create(Request $request) {
        $playlist = new playlists();

        $playlist->id_usuario = Session::get('login');
        $playlist->nome = $request->nome;
        $playlist->descricao = $request->descricao;
        $playlist->duracao = DateInterval::createFromDateString('0 seconds')->format('%H:%I:%S');

        if($request->has('privado')) {
            $playlist->indicador_privado = true;
        } else {
            $playlist->indicador_privado = false;
        }

        $playlist->save();

        return redirect('/playlists');
    }
    public static function createForm(Request $request)
    {
        return view("playlists.playlistsCreate");
    }

    public static function update(Request $request) {

        $indicador_privado = false;
        if($request->has('privado')) {
            $indicador_privado = true;
        }

        DB::table("playlists")->where("id",'=', $request->playlist_id)->update(['nome' => $request->nome, 'descricao' => $request->descricao, 'indicador_privado' => $indicador_privado]);

        return redirect('/playlists/details/'. $request->playlist_id);
    }
    public static function edit($playlist_id) {
        $playlist = DB::table('playlists')->where('id', '=', $playlist_id)->get()->first();
        $musicas = DB::table('musicas')
        ->leftJoin('playlist_possui_musicas', 'musicas.id', '=', 'playlist_possui_musicas.id_musica')
        ->where('playlist_possui_musicas.id_playlist', '=', $playlist_id)
        ->select('musicas.*')
        ->get();

        return view('playlists.playlistsEdit', compact('playlist','musicas'));
    }

    public static function addMusica(Request $request) {
        $musica = $request->musica;
        $playlist = $request->playlist;

        DB::table('playlist_possui_musicas')->insert([
            'id_playlist' => $playlist,
            'id_musica' => $musica,
            //TODO: increase playlist duration
        ]);
    }

    public static function removeMusica(Request $request) {
        $musica = $request->musica;
        $playlist = $request->playlist;

        DB::table('playlist_possui_musicas')
            ->where('id_playlist','=',$playlist)
            ->where('id_musica','=', $musica)
            ->delete();
            //TODO: decrease playlist duration
    }

    public static function removeAndUpdate(Request $request) {
        $musica = $request->musica;
        $playlist = $request->playlist;

        DB::table('playlist_possui_musicas')->where('id_playlist','=',$playlist)->where('id_musica','=', $musica)->delete();

        return redirect('/playlists/details/'.$playlist.'/edit');
        //TODO: decrease playlist duration
    }

    public static function addMusicaForm($id_playlist){
        $musicas = DB::table('musicas')->get();
        $playlist = $id_playlist;

        return view('playlists.playlistsAddMusic',compact('musicas','playlist'));
    }
}
