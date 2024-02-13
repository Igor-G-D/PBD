<?php

use App\Http\Controllers\PlaylistsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\AlbumsController;
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

Route::get('/playlists', [PlaylistsController::class,'show'])->name('playlists.show');
Route::post('/playlists/delete',[PlaylistsController::class,'delete'])->name('playlists.delete');
Route::post('/playlists/unlike',[PlaylistsController::class,'unlike'])->name('playlists.delete');
Route::get('/playlists/details/{playlist_id}', [PlaylistsController::class,'details'])->name('playlists.details');
Route::get('/playlists/details/{playlist_id}/edit', [PlaylistsController::class,'edit'])->name('playlists.details');

Route::get('/albums', [AlbumsController::class,'show'])->name('albums.show');
Route::post('/albums/delete',[AlbumsController::class,'delete'])->name('albums.delete');
Route::post('/albums/unlike',[AlbumsController::class,'unlike'])->name('albums.delete');
Route::get('/albums/details/{album_id}', [AlbumsController::class,'details'])->name('albums.details');
Route::get('/albums/details/{album_id}/edit', [AlbumsController::class,'edit'])->name('albums.details');
