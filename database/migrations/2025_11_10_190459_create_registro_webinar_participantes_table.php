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
        Schema::create('registro_webinar_participantes', function (Blueprint $table) {
            $table->id();

            // 🔹 Relaciones
            $table->unsignedBigInteger('webinar_id')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();

            // 🔹 Datos personales
            $table->string('nombre')->nullable();
            $table->string('apellido')->nullable();
            $table->string('telefono')->nullable();
            $table->string('documento_identidad')->nullable();

            // 🔹 Datos demográficos
            $table->string('grupo_poblacional')->nullable();
            $table->string('etnia')->nullable();
            $table->string('sexo', 20)->nullable();
            $table->string('estado', 50)->nullable();
            $table->integer('edad')->nullable();
            $table->string('barrio')->nullable();
            $table->string('comuna')->nullable();

            // 🔹 Control de creación / actualización
            $table->timestamps();

            // 🔹 Claves foráneas
            $table->foreign('webinar_id')
                ->references('id')
                ->on('webinars')
                ->onDelete('cascade');

            $table->foreign('usuario_id')
                ->references('id')
                ->on('usuarios')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_webinar_participantes');
    }
};
