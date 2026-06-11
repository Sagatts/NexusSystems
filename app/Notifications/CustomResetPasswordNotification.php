<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPasswordNotification extends ResetPassword
{
    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->email,
        ], false));

        return (new MailMessage)
            ->subject('Recuperación de Contraseña - La Picá de Yiyo')
            ->greeting('Hola '.$notifiable->nombre.' 👋')
            ->line('Hemos recibido una solicitud para restablecer tu contraseña.')
            ->line('Haz clic en el siguiente botón para crear una nueva contraseña.')
            ->action('Restablecer Contraseña', $url)
            ->line('Este enlace expirará en 60 minutos.')
            ->line('Si no solicitaste este cambio, puedes ignorar este correo.')
            ->salutation('La Picá de Yiyo');
    }
}