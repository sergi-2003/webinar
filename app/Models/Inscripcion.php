<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;

    protected $table = 'inscripciones';
    public $timestamps = false;

    // ✅ Campos que se pueden asignar masivamente
    protected $fillable = [
        'usuario_id',
        'webinar_id',
        'fecha_inscripcion',
        'estado', 
    ];

    // ✅ Relación con usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // ✅ Relación con webinar
    public function webinar()
    {
        return $this->belongsTo(Webinar::class, 'webinar_id');
    }

    // ✅ Accesor (opcional): nombre legible del estado
    public function getEstadoNombreAttribute()
    {
        return match($this->estado) {
            'pendiente' => 'Pendiente de inicio',
            'activo' => 'En curso',
            'finalizado' => 'Finalizado',
            default => 'Desconocido'
        };
    }
public function registroParticipante()
{
    return $this->hasOne(
        RegistroWebinarParticipante::class,
        'webinar_id',   // campo en registro_webinar_participantes
        'webinar_id'    // campo en inscripciones
    );
}

    
}
