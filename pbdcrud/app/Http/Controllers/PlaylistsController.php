<?php

namespace App\Http\Controllers;

use App\Models\usuarios;
use App\Models\playlists;
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
        DB::table('playlists')->where('id','=',$playlist_id)->delete();
        return redirect('/playlists');
    }

}
