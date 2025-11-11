<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Webinar;
use App\Models\User;

class ConfirmacionInscripcion extends Mailable
{
    use Queueable, SerializesModels;

    public $webinar;
    public $user;

    public function __construct(Webinar $webinar, User $user)
    {
        $this->webinar = $webinar;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Confirmación de inscripción al webinar')
                    ->view('emails.confirmacion-inscripcion');
    }
}
