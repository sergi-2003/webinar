<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;

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
        'activo',
        'fecha_registro',
        'telefono',
        'is_admin',
    ];

    // ✅ Ocultar el password en serialización
    protected $hidden = [
        'password',
        'remember_token',
    ];

  
    public function isAdmin()
      {
          return $this->role === 'admin';
      }

      

      public function inscripciones()
{
    return $this->hasMany(\App\Models\Inscripcion::class, 'usuario_id');
}

public function scopeActivos($query)
{
    return $query->where('activo', true);
}
protected $casts = [
    'is_admin' => 'boolean',
    'password' => 'hashed',
    'activo' => 'boolean',
];



public function sendPasswordResetNotification($token)
{
    $this->notify(new ResetPasswordNotification($token));
}

protected static function boot()
{
    parent::boot();

    static::creating(function ($usuario) {
        if (empty($usuario->fecha_registro)) {
            $usuario->fecha_registro = now();
        }
    });
}

}
