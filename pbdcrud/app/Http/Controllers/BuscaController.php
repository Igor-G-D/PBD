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
    public static function show(Request $request)
    {
        $nome = $type = $duracao = $orderby = null;
        $order = "desc";
        if (empty($request->query())) {
            $nome = "";
            $type = "musicas";
            $duracao = 180;
            $orderby = "nome";
        } else {
            $nome = $request->nome;
            $type = $request->type;
            $duracao = $request->duracao;
            $orderby = $request->orderby;
        }

        if ($request->has('order')) {
            $order = $request->order;
        }

        $duracaoInterval = DB::raw("make_interval(mins => $duracao)");
        $searchResults = DB::table($type)->where('duracao', '<', $duracaoInterval);

        if($nome != '') {
            $searchResults->where('nome', 'like', '%' . $nome . '%');
        }

        switch ($orderby) {
            case 'nome':
                $searchResults->orderBy('nome', $order);
                break;
            case 'nLikes':
                $likeTableName = 'curte_' . $type;
                $searchResults
                    ->leftJoin($likeTableName, $type . '.id', '=', $likeTableName . '.id_' . substr($type, 0, -1))
                    ->select($type . '.*', DB::raw('COUNT(DISTINCT ' . $likeTableName . '.id_usuario) AS totallikes'))
                    ->groupBy($type . '.id')
                    ->orderBy('totallikes', $order);
                break;
            case 'duracao':
                $searchResults->orderBy('duracao', $order);
                break;
        }

        $results = $searchResults->get();

        return view("search",compact('results','type'));
    }
}
