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
        Schema::create('playlists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ID_Usuario');
            $table->foreign('ID_Usuario')->references('id')->on('usuarios');
            $table->string('Nome', 100);
            $table->text('Descricao')->nullable(); // Assuming Descricao can be nullable
            $table->boolean('Indicador_Privado');
            $table->interval('Duracao_Total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlists');
    }
};
