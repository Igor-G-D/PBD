<?php

namespace App\Http\Controllers;

use App\Models\usuarios;
use App\Models\albums;
use App\Models\curte_albums;
use DateInterval;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AlbumsController extends Controller
{
    public static function show()
    {
        $userSession = Session::get('login');
        if($userSession == null) {
            return redirect('/');
        }

        $userAlbums = DB::table('albums')->where('id_usuario', $userSession)->get();
        $likedAlbums = DB::table('albums')
        ->join('curte_albums', 'albums.id', '=', 'curte_albums.id_album')
        ->where('curte_albums.id_usuario', '=', $userSession)
        ->select('albums.*')
        ->get();
        return view("albums.albumsDashboard", compact('userAlbums','likedAlbums'));
    }

    public static function delete(Request $request)
    {
        $album_id = $request->album;

        $albumOwner = DB::table('albums')->where('id','=',$album_id)->first()->id_usuario;

        if(SESSION::get('login') != $albumOwner) {
            return redirect('/albums')->with('error','Você não é o dono desta album!');
        }
        DB::transaction(function () use ($album_id) {
            DB::table('curte_albums')->where('id_album', '=', $album_id)->delete();
            DB::table('curte_musicas')
                ->leftJoin('musicas', 'curte_musicas.id_musica', '=', 'musicas.id')
                ->where('musicas.id_album', '=', $album_id)
                ->delete();
            DB::table('playlist_possui_musicas')
                ->leftJoin('musicas', 'playlist_possui_musicas.id_musica', '=', 'musicas.id')
                ->where('musicas.id_album', '=', $album_id)
                ->delete();
            DB::table('tem_autoria')
                ->leftJoin('musicas', 'tem_autoria.id_musica', '=', 'musicas.id')
                ->where('musicas.id_album', '=', $album_id)
                ->delete();
            DB::table('musicas')->where('id_album', '=', $album_id)->delete();
            DB::table('albums')->where('id', '=', $album_id)->delete();
        });
        return redirect('/albums');
    }

    public static function unlike(Request $request)
    {
        $album_id = $request->id;

        $session_id = SESSION::get('login');

        DB::table('curte_albums')
            ->where('id_album','=',$album_id)
            ->where('id_usuario','=', $session_id)
            ->delete();
    }

    public static function like(Request $request)
    {

        $id_album = $request->id;
        $id_usuario = Session::get('login');

        DB::table('curte_albums')->insert([
            'id_usuario' => $id_usuario,
            'id_album' => $id_album,
        ]);
    }

    public static function details($album_id) {
        $album = DB::table('albums')->where('id', $album_id)->first();

        $musicas = DB::table('musicas')
        ->where('musicas.id_album', '=', $album->id)
        ->get();
        return view('albums.albumsDetails',compact('album', 'musicas'));
    }

    public static function createForm(Request $request)
    {
        return view("albums.albumsCreate");
    }

    public static function create(Request $request) {
        $album = new albums();

        $album->id_usuario = Session::get('login');
        $album->nome = $request->nome;
        $album->duracao = DateInterval::createFromDateString('0 seconds')->format('%H:%I:%S');

        $album->save();

        return redirect('/albums/'.$album->id.'/music');
    }

    public static function musicForm($album_id) {
        $musicas = DB::table('musicas')->where('id_album','=', $album_id)->get();
        $nome = DB::table('albums')->where('id','=', $album_id)->first()->nome;

        return view('albums.albumsMusic',compact('musicas','nome'));
    }

}
