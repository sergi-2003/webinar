<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{


public function run(): void
{
    // Usuario admin
    User::create([
        'name' => 'Administrador',
        'email' => 'admin@webinar.com',
        'password' => Hash::make('admin123'),
        'rol' => 'admin',
    ]);

    // Usuario normal
    User::create([
        'name' => 'Usuario Prueba',
        'email' => 'usuario@webinar.com',
        'password' => Hash::make('usuario123'),
        'rol' => 'cliente',
    ]);
}

}
