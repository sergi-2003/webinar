<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirmación de inscripción</title>
</head>
<body>
    <h2>Hola {{ $user->nombre }},</h2>
    <p>Te has inscrito exitosamente al webinar:</p>
    <h3>{{ $webinar->titulo }}</h3>
    <p>📅 Fecha: {{ $webinar->fecha }} <br>
       🕒 Hora: {{ $webinar->hora_inicio }}</p>

    <p>Haz clic en el siguiente enlace para acceder cuando inicie:</p>
    <a href="{{ route('webinars.acceder', $webinar->id) }}">Entrar al webinar</a>

    <br><br>
    <p>¡Gracias por participar!</p>
</body>
</html>
