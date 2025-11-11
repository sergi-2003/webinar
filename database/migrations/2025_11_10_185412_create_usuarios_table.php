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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();

            // Datos personales
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('password');

            // Rol y estado
            $table->string('role')->default('usuario'); // admin | usuario
            $table->boolean('is_admin')->default(false);
            $table->boolean('activo')->default(true);

            // Información adicional
            $table->string('telefono')->nullable();
            $table->timestamp('fecha_registro')->nullable();

            // Tokens y autenticación
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
