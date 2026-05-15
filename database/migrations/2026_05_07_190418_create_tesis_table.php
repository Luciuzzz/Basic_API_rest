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
        Schema::create('tesis', function (Blueprint $table) {
            $table->id('id_tesis');
            $table->string('titulo', 255);
            $table->text('descripcion');
            $table->string('url_contenido', 500);
            $table->date('fecha_creacion');
            $table->foreignId('id_autor')->constrained('autores', 'id_autor')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('id_area')->constrained('areas', 'id_area')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('id_carrera')->constrained('carreras', 'id_carrera')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tesis');
    }
};
