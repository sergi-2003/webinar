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
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('webinar_id');

            // Datos de inscripción
            $table->dateTime('fecha_inscripcion')->nullable();
            $table->string('estado')->default('pendiente'); // pendiente | activo | finalizado

            // 🔗 Llaves foráneas
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('webinar_id')->references('id')->on('webinars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripciones');
    }
};
