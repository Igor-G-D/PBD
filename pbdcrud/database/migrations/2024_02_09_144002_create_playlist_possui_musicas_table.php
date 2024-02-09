<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('playlist_possui_musicas', function (Blueprint $table) {
            $table->unsignedBigInteger('ID_Playlist');
            $table->unsignedBigInteger('ID_Musica');
            $table->primary(['ID_Playlist', 'ID_Musica']);
            $table->foreign('ID_Playlist')->references('id')->on('playlists');
            $table->foreign('ID_Musica')->references('id')->on('musicas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlist_possui_musicas');
    }
};
