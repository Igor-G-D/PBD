<?php

use App\Http\Controllers\PlaylistsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
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
