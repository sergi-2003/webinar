@extends('layouts.app')

@section('title', 'Acceso al Webinar')

@section('content')
<div class="container py-5 text-center">
    <div class="card shadow-lg mx-auto" style="max-width: 500px; border-radius: 16px;">
        <div class="card-body p-5">
            <h2 class="fw-bold text-success mb-3">
                🔒 Acceso al Webinar Privado
            </h2>
            <p class="text-muted mb-4">
                Ingrese la contraseña para acceder al webinar:  
                <strong>{{ $webinar->titulo }}</strong>
            </p>

            @if ($errors->any())
                <div class="alert alert-danger small">
                    {{ $errors->first('password') }}
                </div>
            @endif

            <form method="POST" action="{{ route('cliente.webinars.validar', $webinar->id) }}">
                @csrf
                <div class="mb-4">
                    <input type="password" name="password" class="form-control form-control-lg text-center rounded-pill" placeholder="Ingrese la contraseña" required>
                </div>
                <button type="submit" class="btn btn-success w-100 rounded-pill py-2 fw-semibold shadow-sm">
                    <i class="bi bi-unlock-fill me-1"></i> Ingresar
                </button>
            </form>

            <a href="{{ route('cliente.webinars.index') }}" class="d-block mt-4 text-decoration-none text-muted">
                <i class="bi bi-arrow-left"></i> Volver al panel
            </a>
        </div>
    </div>
</div>

<style>
body {
    background: linear-gradient(135deg, #f4f9f4, #eafbea);
}
</style>
@endsection
