<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;

    protected $table = 'inscripciones';

    protected $fillable = [
        'usuario_id',
        'webinar_id',
        'fecha_inscripcion',
    ];

    // 🔗 Relación con usuarios
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // 🔗 Relación con webinars
    public function webinar()
    {
        return $this->belongsTo(Webinar::class, 'webinar_id');
    }
}
