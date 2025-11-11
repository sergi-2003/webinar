<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grabacion extends Model
{
    use HasFactory;

        protected $table = 'grabaciones';
        

    protected $fillable = [
        'titulo',
        'descripcion',
        'video_url',
        'miniatura',
        'fecha_publicacion',
        'usuario_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
