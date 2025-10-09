@extends('layouts.app')

@section('title', 'Ver Webinar')

@section('content')
<div class="container py-5 text-center">
    <h2 class="fw-bold text-success mb-3">{{ $webinar->titulo }}</h2>
    <p class="text-muted">{{ $webinar->descripcion }}</p>

    <div id="jitsi-container" style="height: 80vh; border-radius: 10px; overflow: hidden;" class="shadow-lg"></div>
</div>

<script src="https://meet.jit.si/external_api.js"></script>
<script>
    const domain = 'meet.jit.si';
    const options = {
        roomName: "{{ basename($webinar->video_url) }}",
        width: '100%',
        height: 600,
        parentNode: document.getElementById('jitsi-container'),
        configOverwrite: {},
        interfaceConfigOverwrite: {},
    };

    const api = new JitsiMeetExternalAPI(domain, options);

    // Si el webinar tiene clave, la aplicamos dentro del iframe (no visible al usuario)
    @if ($webinar->password)
        api.addEventListener('participantRoleChanged', event => {
            if (event.role === 'moderator') {
                api.executeCommand('password', '{{ $webinar->password }}');
            }
        });
    @endif
</script>
@endsection
