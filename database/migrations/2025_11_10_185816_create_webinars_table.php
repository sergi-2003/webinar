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
        Schema::create('webinars', function (Blueprint $table) {
            $table->id();

            // Información básica
            $table->string('titulo');
            $table->text('descripcion')->nullable();

            // Fecha y horarios
            $table->date('fecha')->nullable();
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();

            // Estado y configuración
            $table->string('estado')->default('Programado'); // Programado | En curso | Finalizado
            $table->string('video_url')->nullable(); // Enlace Meet o Zoom
            $table->string('password')->nullable();
            $table->boolean('privado')->default(false);

            // Relación con usuario creador
            $table->unsignedBigInteger('creado_por')->nullable();
            $table->foreign('creado_por')->references('id')->on('usuarios')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webinars');
    }
};
