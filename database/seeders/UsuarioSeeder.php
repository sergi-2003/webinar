<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        Usuario::create([
            'nombre' => 'Admin Principal',
            'email' => 'admin@webinar.com',
            'password' => Hash::make('admin123'),
            'rol' => 'admin',
            'telefono' => '3001234567',
        ]);

        // Cliente
        Usuario::create([
            'nombre' => 'Cliente Ejemplo',
            'email' => 'cliente@webinar.com',
            'password' => Hash::make('cliente123'),
            'rol' => 'cliente',
            'telefono' => '3109876543',
        ]);
    }
}
