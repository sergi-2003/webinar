@component('mail::message')
# ¡Hola {{ $usuario->nombre }}! 👋

Has confirmado tu asistencia al siguiente webinar:

**Tema:** {{ $webinar->titulo }}  
**Fecha:** {{ \Carbon\Carbon::parse($webinar->fecha)->format('d/m/Y H:i') }}  
**Ponente:** {{ $webinar->ponente }}

@component('mail::button', ['url' => route('webinars.show', $webinar->id)])
Ver Detalles del Webinar
@endcomponent

Gracias por ser parte de nuestra comunidad educativa.<br>
**{{ config('app.name') }}**
@endcomponent
