<?php

namespace App\Http\Controllers;

use App\Models\usuarios;
use App\Models\playlists;
use DateInterval;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    private function verifyLoggedIn($redirect) {
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

    public function signup()
    {
        return $this->verifyLoggedIn('user.signup');
    }

    public function create_new_usuario(Request $request)
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
        $playlistCurtidas->duracao_total = DateInterval::createFromDateString('0 seconds')->format('%H:%I:%S');

        $usuario->save();

        $playlistCurtidas->id_usuario = (DB::table('usuarios')->where('nome', $nome)->first())->id;

        $playlistCurtidas->save();
        return redirect('/login')->with('success','Registered Successfully!');
    }

    public function login_action(Request $request)
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
    public function logout_action()
    {
        Session::forget('login');
        return redirect('/');
    }


}
