<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios'; // importante
    protected $primaryKey = 'id';  
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'role', // aquí guardamos si es admin o cliente
    ];

    // Método helper
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
