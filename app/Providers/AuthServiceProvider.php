<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate; 
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Usuario; // Asegúrate de que esta línea esté presente


class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot(): void
    {
        // Definir la Gate 'acceso-admin'
        // app/Providers/AuthServiceProvider.php

Gate::define('acceso-admin', function (\App\Models\Usuario $user) {
    
    // ✅ CORRECCIÓN: Usamos strval() para asegurar que $user->role sea una cadena PHP simple
    // antes de usar trim() y la comparación estricta.
    return trim(strval($user->role)) === 'admin'; 
});
    }
}