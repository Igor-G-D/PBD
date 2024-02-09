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
        Schema::create('curte_albums', function (Blueprint $table) {
            $table->unsignedBigInteger('ID_Usuario');
            $table->unsignedBigInteger('ID_Album');
            $table->primary(['ID_Usuario', 'ID_Album']);
            $table->foreign('ID_Usuario')->references('id')->on('usuarios');
            $table->foreign('ID_Album')->references('id')->on('albums');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curte_albums');
    }
};
