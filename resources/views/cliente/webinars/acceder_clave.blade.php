@extends('layouts.app')

@section('title', 'Acceder al Webinar Privado')

@section('content')
<div class="container py-5" style="max-width: 500px;">
    <h3 class="text-center text-success mb-4">🔒 Acceso al Webinar</h3>

    <div class="card shadow p-4">
        <h5 class="fw-bold text-center mb-3">{{ $webinar->titulo }}</h5>
        <form action="{{ route('cliente.webinars.validar', $webinar->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Contraseña del webinar</label>
                <input type="password" name="password" id="password" class="form-control" required>
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-success w-100 fw-bold">Ingresar</button>
        </form>
    </div>

    <div class="text-center mt-3">
        <a href="{{ route('cliente.webinars.index') }}" class="text-muted text-decoration-none">⬅ Volver al panel</a>
    </div>
</div>
@endsection
api.addEventListener('passwordRequired', () => {
    api.executeCommand('password', '{{ $webinar->password ?? 'webinar' . $webinar->id }}');
});
