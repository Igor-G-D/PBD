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
        Schema::create('curte_playlists', function (Blueprint $table) {
            $table->unsignedBigInteger('ID_Playlist');
            $table->unsignedBigInteger('ID_Usuario');
            $table->primary(['ID_Playlist', 'ID_Usuario']);
            $table->foreign('ID_Playlist')->references('id')->on('playlists');
            $table->foreign('ID_Usuario')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curte_playlists');
    }
};
