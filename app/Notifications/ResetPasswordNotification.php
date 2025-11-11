<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotificationBase;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPasswordNotificationBase
{
    public function toMail($notifiable)
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        $appName = config('app.name');

        return (new MailMessage)
            ->subject('🔒 Restablece tu contraseña en ' . $appName)
            ->greeting('Hola ' . ucfirst($notifiable->name ?? 'usuario') . ' 👋')
            ->line('Recibimos una solicitud para restablecer tu contraseña en **' . $appName . '**.')
            ->line('Haz clic en el siguiente botón para crear una nueva contraseña segura:')
            ->action('Restablecer contraseña', $resetUrl)
            ->line('⚠️ Este enlace estará disponible solo durante 60 minutos por motivos de seguridad.')
            ->line('Si no solicitaste este cambio, simplemente ignora este correo.')
            ->salutation("💚 Gracias por confiar en nosotros,\nEl equipo de soporte de $appName.");
    }
}
