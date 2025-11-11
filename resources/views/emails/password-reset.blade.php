@component('mail::message')
{{-- HEADER PERSONALIZADO --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
<img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" style="height: 50px; margin-bottom: 10px;">
@endcomponent
@endslot

# 🔒 ¡Hola {{ $user->name ?? 'Usuario' }}!

Hemos recibido una solicitud para restablecer tu contraseña en **{{ $appName }}**.  
Haz clic en el siguiente botón para crear una nueva:

@component('mail::button', ['url' => $url, 'color' => 'primary'])
Restablecer contraseña
@endcomponent

> ⚠️ Este enlace será válido solo durante 60 minutos por motivos de seguridad.

Si tú **no solicitaste este cambio**, puedes ignorar este correo.  
Tu contraseña actual seguirá siendo válida.

Gracias por confiar en nosotros 💙  
El equipo de **{{ $appName }}**

{{-- FOOTER --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ $appName }}. Todos los derechos reservados.  
Si necesitas ayuda, contáctanos en [soporte@{{ Str::slug($appName) }}.com](mailto:soporte@{{ Str::slug($appName) }}.com)
@endcomponent
@endslot
@endcomponent
