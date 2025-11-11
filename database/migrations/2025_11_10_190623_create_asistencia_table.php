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
        Schema::create('asistencia', function (Blueprint $table) {
            $table->id();

            // 🔹 Relaciones
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->unsignedBigInteger('webinar_id')->nullable();

            // 🔹 Datos de asistencia
            $table->integer('tiempo_conectado')->nullable()->comment('Tiempo conectado en minutos');

            // 🔹 Control de registro
            $table->timestamps();

            // 🔹 Claves foráneas
            $table->foreign('usuario_id')
                ->references('id')
                ->on('usuarios')
                ->onDelete('cascade');

            $table->foreign('webinar_id')
                ->references('id')
                ->on('webinars')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencia');
    }
};
