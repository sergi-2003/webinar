@extends('layouts.app')

@section('title', 'Ver webinar')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold mb-4">{{ $webinar->titulo }}</h3>

    <iframe
        src="{{ $webinar->video_url }}#userInfo.displayName='Participante'&config.enableWelcomePage=false"
        style="width: 100%; height: 80vh; border: none;"
        allow="camera; microphone; fullscreen"
    ></iframe>
</div>
@endsection
