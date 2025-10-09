<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    // ✅ Nombre real de la tabla
    protected $table = 'usuarios';

    // ✅ Laravel no debe intentar guardar created_at / updated_at
    public $timestamps = false;

    // ✅ Campos que pueden ser llenados
    protected $fillable = [
        'nombre',
        'email',
        'password',
        'role',
        'fecha_registro',
        'telefono',
        'is_admin',
    ];

    // ✅ Ocultar el password en serialización
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ✅ Tipos de datos
    protected function casts(): array
    {
        return [
            'is_admin' => 'boolean',
            'password' => 'hashed',
        ];
    }
    public function isAdmin()
      {
          return $this->role === 'admin';
      }
}
