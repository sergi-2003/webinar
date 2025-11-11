<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroWebinarParticipante extends Model
{
    use HasFactory;

    protected $table = 'registro_webinar_participantes';
    public $timestamps = true;

    protected $fillable = [
        'webinar_id',
        'usuario_id', 
        'nombre',
        'apellido',
        'telefono',
        'documento_identidad',
        'grupo_poblacional',
        'etnia',
        'sexo',
        'estado',
         'edad',
        'barrio',
        'comuna',

    ];

    // 🔹 Relación con Webinar
    public function webinar()
    {
        return $this->belongsTo(Webinar::class, 'webinar_id');
    }

    // 🔹 Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
