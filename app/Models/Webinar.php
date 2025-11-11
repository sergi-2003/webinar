<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webinar extends Model
{
    use HasFactory;

    protected $table = 'webinars';
    public $timestamps = false;
    
    

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha',
        'estado',
        'video_url',
        'password',
        'creado_por',
        'hora_inicio',
        'hora_fin',
        'privado',

    ];

          protected $casts = [
        'fecha' => 'datetime',
        'hora_fin' => 'datetime',
        'privado' => 'boolean',
    ];

    public function creador()
{
    return $this->belongsTo(User::class, 'creado_por');
}


public function inscripciones()
{
    return $this->hasMany(\App\Models\Inscripcion::class, 'webinar_id');
}

public function participantes()
{
    return $this->hasMany(RegistroWebinarParticipante::class, 'webinar_id');
}



}
