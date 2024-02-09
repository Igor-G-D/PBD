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
        Schema::create('musicas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ID_Album');
            $table->foreign('ID_Album')->references('id')->on('albums');
            $table->string('Nome', 100);
            $table->string('Genero', 50)->nullable(); // Assuming Genero can be nullable
            $table->interval('Duracao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('musicas');
    }
};
