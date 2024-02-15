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

class UsuariosController extends Controller
{
    private static function verifyLoggedIn($redirect) {
        if(Session::get('login') == null) {
            return view($redirect);
        } else {
            return redirect('/playlists')->with('error', 'já está logado!');
        }
    }
    public function login()
    {
        return $this->verifyLoggedIn('user.login');
    }

    public static function signup()
    {
        return UsuariosController::verifyLoggedIn('user.signup');
    }

    public static function create_new_usuario(Request $request)
    {
        $nome = $request->input('nome');
        $cpf = $request->input('cpf');
        $senha = $request->input('senha');

        $usuario = new Usuarios();

        $usuario->nome = $nome;
        $usuario->cpf = $cpf;
        $usuario->senha = $senha;
        $usuario->id_distribuidor = null;

        $playlistCurtidas = new Playlists();

        $playlistCurtidas->nome = "Músicas Curtidas";
        $playlistCurtidas->descricao = "Músicas curtidas por você";
        $playlistCurtidas->indicador_privado = true;
        $playlistCurtidas-> duracao = DateInterval::createFromDateString('0 seconds')->format('%H:%I:%S');

        $usuario->save();

        $playlistCurtidas->id_usuario = (DB::table('usuarios')->where('nome', $nome)->first())->id;

        $playlistCurtidas->save();
        return redirect('/login')->with('success','Registered Successfully!');
    }

    public static function login_action(Request $request)
    {
        $nome = $request->input('nome');
        $senha = $request->input('senha');

        $usuario = DB::table('usuarios')->where('nome', $nome)->first();

        if ($usuario === null) {
            return redirect('/login')->with('error', 'Usuário não existe!');
        } elseif ($usuario->senha !== $senha) {
            return redirect('/login')->with('error', 'Senha incorreta!');
        } else {
            Session::put('login', $usuario->id);
            return redirect('/playlists');
        }
    }
    public static function logout_action()
    {
        Session::forget('login');
        return redirect('/');
    }

    public static function show($user_id) {

        $userSession = Session::get('login');
        if($userSession == null) {
            return redirect('/');
        }

        $usuario = DB::table('usuarios')->where('id', $user_id)->first();

        if($usuario == null) {
            return redirect('/')->with('error','usuario não existe!');
        }

        $nAlbums = DB::table('albums')->where('id_usuario','=',$user_id)->get()->count();
        $nPlaylists = DB::table('playlists')->where('id_usuario','=',$user_id)->get()->count();
        $nMusicas = DB::table('tem_autoria')->where('id_usuario','=',$user_id)->get()->count();
        return view('user.userDetails',compact('usuario','nAlbums','nPlaylists','nMusicas'));
    }

    public static function delete(Request $request) {
        $userSession = Session::get('login');
        $user_id = $request->usuario;

        if($user_id != $userSession) {
            return redirect('/')->with('error', 'você não está logado como esse usuário!');
        }
        DB::transaction(function () use ($user_id) {
            $playlists = DB::table('playlists')->where('id_usuario','=',$user_id)->get();
            foreach ($playlists as $playlist) {
                $request = new Request();
                $request->merge(['playlist' => $playlist->id]);
                PlaylistsController::delete($request);
            }
            $albums = DB::table('albums')->where('id_usuario','=',$user_id)->get();
            foreach ($albums as $album) {
                $request = new Request();
                $request->merge(['album' => $album->id]);
                AlbumsController::delete($album->id);
            }
            DB::table('tem_autoria')->where('id_usuario','=',$user_id)->delete();
            DB::table('curte_albums')->where('id_usuario','=',$user_id)->delete();
            DB::table('curte_playlists')->where('id_usuario','=',$user_id)->delete();
            DB::table('curte_musicas')->where('id_usuario','=',$user_id)->delete();
            DB::table('usuarios')->where('id','=',$user_id)->delete();
        });
        UsuariosController::logout_action();
        return redirect('/');
    }

}
