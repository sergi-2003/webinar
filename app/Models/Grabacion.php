<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grabacion extends Model
{
    use HasFactory;

    protected $table = 'grabaciones';

    protected $fillable = [
        'webinar_id',
        'titulo',
        'video_url',
    ];

    public function webinar()
    {
        return $this->belongsTo(Webinar::class, 'webinar_id');
    }
}
