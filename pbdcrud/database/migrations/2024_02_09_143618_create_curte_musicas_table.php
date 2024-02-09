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
        Schema::create('curte_musicas', function (Blueprint $table) {
            $table->unsignedBigInteger('ID_Usuario');
            $table->unsignedBigInteger('ID_Musica');
            $table->primary(['ID_Usuario', 'ID_Musica']);
            $table->foreign('ID_Usuario')->references('id')->on('usuarios');
            $table->foreign('ID_Musica')->references('id')->on('musicas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curte_musicas');
    }
};
