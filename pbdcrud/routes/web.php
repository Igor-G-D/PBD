<?php

use App\Http\Controllers\PlaylistsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\AlbumsController;
use App\Http\Controllers\BuscaController;
use App\Http\Controllers\MusicasController;
use App\Policies\UsuariosPolicy;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if(Session::get('login') == null) {
        return redirect("/login");
    } else {
        return redirect('/playlists');
    }
});
Route::get('/login', [UsuariosController::class,'login'])->name('user.login');
Route::post('/login', [UsuariosController::class,'login_action'])->name('user.login.action');
Route::get('/signup', [UsuariosController::class,'signup'])->name('user.signup');
Route::post('/signup', [UsuariosController::class,'create_new_usuario'])->name('user.create_new_usuario');
Route::get('/logout', [UsuariosController::class,'logout_action'])->name('user.logoff');
Route::get('/users/details/{usuario_id}/edit', [UsuariosController::class,'updateForm'])->name('user.updateForm');
Route::post('/users/details/{usuario_id}/edit', [UsuariosController::class,'update'])->name('user.update');

Route::get('/users/details/{users_id}', [UsuariosController::class,'show'])->name('users.details');
Route::post('/users/delete',[UsuariosController::class,'delete'])->name('users.delete');

Route::get('/playlists', [PlaylistsController::class,'show'])->name('playlists.show');
Route::post('/playlists/delete',[PlaylistsController::class,'delete'])->name('playlists.delete');
Route::post('/playlists/unlike',[PlaylistsController::class,'unlike'])->name('playlists.unlike');
Route::post('/playlists/like',[PlaylistsController::class,'like'])->name('playlists.like');
Route::get('/playlists/details/{playlist_id}', [PlaylistsController::class,'details'])->name('playlists.details');
Route::get('/playlists/create', [PlaylistsController::class,'createForm'])->name('playlists.createForm');
Route::post('/playlists/create', [PlaylistsController::class,'create'])->name('playlists.create');
Route::get('/playlists/details/{playlist_id}/edit', [PlaylistsController::class,'edit'])->name('playlists.edit');
Route::get('/playlists/details/{playlist_id}/edit/add', [PlaylistsController::class,'addMusicaForm'])->name('playlists.edit.add');
Route::post('/playlists/details/{playlist_id}/edit/add', [PlaylistsController::class,'addMusica'])->name('playlists.edit.add');
Route::post('/playlists/details/{playlist_id}/edit/remove', [PlaylistsController::class,'removeMusica'])->name('playlists.edit.add');
Route::post('/playlists/details/update', [PlaylistsController::class,'update'])->name('playlists.update');
Route::post('/playlists/details/{playlist_id}/edit/removeAndUpdate', [PlaylistsController::class,'removeAndUpdate'])->name('playlists.removeAndUpdate');

Route::get('/albums', [AlbumsController::class,'show'])->name('albums.show');
Route::post('/albums/delete',[AlbumsController::class,'delete'])->name('albums.delete');
Route::post('/albums/unlike',[AlbumsController::class,'unlike'])->name('albums.unlike');
Route::post('/albums/like',[AlbumsController::class,'like'])->name('albums.like');
Route::get('/albums/details/{album_id}', [AlbumsController::class,'details'])->name('albums.details');
Route::get('/albums/create', [AlbumsController::class,'createForm'])->name('albums.createForm');
Route::post('/albums/create', [AlbumsController::class,'create'])->name('albums.create');
Route::get('/albums/{album_id}/music', [AlbumsController::class,'musicForm'])->name('albums.music');
Route::get('/albums/{album_id}/music/new', [AlbumsController::class,'newMusicForm'])->name('album.music.newForm');
Route::post('/albums/{album_id}/music/new', [AlbumsController::class,'newMusic'])->name('album.music.new');
Route::post('/albums/{album_id}/music/removeAndUpdate', [AlbumsController::class,'removeAndUpdate'])->name('album.music.removeAndUpdate');
Route::get('/albums/{album_id}/music/confirm', [AlbumsController::class,'confirm'])->name('album.confirm');
Route::get('/albums/edit/{album_id}', [AlbumsController::class,'editForm'])->name('albums.editForm');
Route::post('/albums/edit/{album_id}', [AlbumsController::class,'edit'])->name('albums.edit');

Route::post('/musicas/unlike',[MusicasController::class,'unlike'])->name('musicas.unlike');
Route::post('/musicas/like',[MusicasController::class,'like'])->name('musicas.like');

Route::get('/search', [BuscaController::class,'show'])->name('busca.show');
