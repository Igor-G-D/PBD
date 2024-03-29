<?php

namespace App\Http\Controllers;

use App\Models\usuarios;
use App\Models\albums;
use App\Models\curte_albums;
use App\Models\musicas;
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
            $playlist_possui_musicas = DB::table('playlist_possui_musicas')
                ->leftJoin('musicas', 'playlist_possui_musicas.id_musica', '=', 'musicas.id')
                ->where('musicas.id_album', '=', $album_id)->get();

            foreach($playlist_possui_musicas as $playlist_possui_musica) {
                $musica = $playlist_possui_musica->id_musica;
                $playlist = $playlist_possui_musica->id_playlist;
                $duracaoPlaylistDB = DB::table('playlists')->where('id','=',$playlist)->first()->duracao;
                $duracaoMusicaDB = DB::table('musicas')->where('id','=',$musica)->first()->duracao;
                $Mseg = $Mmin =  $Mhour = $Pseg = $Pmin = $Phour = 0 ;
                list($Mhour, $Mmin, $Mseg) = sscanf($duracaoMusicaDB,'%d:%d:%d');
                list($Phour, $Pmin, $Pseg) = sscanf($duracaoPlaylistDB,'%d:%d:%d');
                $duracaoMusicaSeg = $Mhour * 3600 + $Mmin * 60 + $Mseg;
                $duracaoPlaylistSeg = $Phour * 3600 + $Pmin * 60 + $Pseg;

                $novaDuracaoPlaylist = gmdate("H:i:s", $duracaoPlaylistSeg - $duracaoMusicaSeg);

                DB::table('playlists')->where('id','=',$playlist)->update(['duracao' => $novaDuracaoPlaylist]);
            }
            DB::table('playlist_possui_musicas')
                ->leftJoin('musicas', 'playlist_possui_musicas.id_musica', '=', 'musicas.id')
                ->where('musicas.id_album', '=', $album_id)->delete();

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

        return view('albums.albumsMusic',compact('musicas','nome', 'album_id'));
    }

    public static function newMusicForm($album_id) {
        $nome = DB::table('albums')->where('id','=', $album_id)->first()->nome;

        $usuarios = DB::table('usuarios')->where('id','!=', Session::get('login'))->get();
        return view('albums.albumsMusicNew',compact('album_id', 'nome', 'usuarios'));
    }

    public static function newMusic($album_id, Request $request) {
        $musica = new musicas();

        $musica->id_album = $album_id;
        $musica->nome = $request->nome;
        $musica->genero = $request->genero;

        $musica->duracao = DateInterval::createFromDateString($request->minutes.' minutes '.$request->seconds.' seconds')->format('%H:%I:%S');

        $duracaoAlbumDB = DB::table('albums')->where('id','=',$album_id)->first()->duracao;
        $duracaoMusicaDB = $musica->duracao;
        $Mseg = $Mmin =  $Mhour = $Aseg = $Amin = $Ahour = 0 ;
        list($Mhour, $Mmin, $Mseg) = sscanf($duracaoMusicaDB,'%d:%d:%d');
        list($Ahour, $Amin, $Aseg) = sscanf($duracaoAlbumDB,'%d:%d:%d');
        $duracaoMusicaSeg = $Mhour * 3600 + $Mmin * 60 + $Mseg;
        $duracaoAlbumSeg = $Ahour * 3600 + $Amin * 60 + $Aseg;

        $novaDuracaoAlbum = gmdate("H:i:s", $duracaoAlbumSeg + $duracaoMusicaSeg);

        DB::transaction(function () use ($musica, $request, $novaDuracaoAlbum, $album_id) {
            $musica->save();

            DB::table('tem_autoria')->insert([
                'id_usuario' => Session::get('login'),
                'id_musica' => $musica->id,
            ]);

            if($request->coauthor != "") {
                DB::table('tem_autoria')->insert([
                    'id_usuario' => $request->coauthor,
                    'id_musica' => $musica->id,
                ]);
            }

            DB::table('albums')->where('id','=',$album_id)->update(['duracao' => $novaDuracaoAlbum]);
        });

        return redirect('/albums/'.$album_id.'/music');

    }

    public static function removeAndUpdate($album_id, Request $request) {

        $duracaoAlbumDB = DB::table('albums')->where('id','=',$album_id)->first()->duracao;
        $duracaoMusicaDB = DB::table('musicas')->where('id','=',$request->musica)->first()->duracao;
        $Mseg = $Mmin =  $Mhour = $Aseg = $Amin = $Ahour = 0 ;
        list($Mhour, $Mmin, $Mseg) = sscanf($duracaoMusicaDB,'%d:%d:%d');
        list($Ahour, $Amin, $Aseg) = sscanf($duracaoAlbumDB,'%d:%d:%d');
        $duracaoMusicaSeg = $Mhour * 3600 + $Mmin * 60 + $Mseg;
        $duracaoAlbumSeg = $Ahour * 3600 + $Amin * 60 + $Aseg;

        $novaDuracaoAlbum = gmdate("H:i:s", $duracaoAlbumSeg - $duracaoMusicaSeg);

        DB::transaction(function () use ($request, $album_id, $novaDuracaoAlbum) {
            DB::table('tem_autoria')->where('id_musica','=',$request->musica)->delete();
            DB::table('musicas')->where('id','=',$request->musica)->delete();

            DB::table('albums')->where('id','=',$album_id)->update(['duracao' => $novaDuracaoAlbum]);
        });

        return redirect('/albums/'.$album_id.'/music');
    }

    public static function confirm($album_id) {
        $nMusicas = DB::table('musicas')->where('id_album','=', $album_id)->get()->count();
        if($nMusicas == 0) {
            DB::table('albums')->where('id','=',$album_id)->delete();
        }

        return redirect('/albums');
    }

    public static function editForm($album_id) {
        $album = DB::table('albums')->where('id','=', $album_id)->first();

        return view('albums.albumsEdit',compact('album'));
    }

    public static function edit($album_id, Request $request) {
        DB::table("albums")->where("id",'=', $album_id)->update(['nome' => $request->nome]);
        return redirect('/albums/'.$album_id.'/music');
    }
}
