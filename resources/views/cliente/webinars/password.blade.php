@extends('layouts.app')

@section('title', 'Acceso a webinar privado')

@section('content')
<div class="container py-5" style="max-width: 500px;">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-success text-white text-center py-3 rounded-top-4">
            <h4 class="mb-0 fw-bold">🔒 Acceso al webinar privado</h4>
        </div>

        <div class="card-body p-4">
            <div class="text-center mb-3">
                <h5 class="fw-semibold">{{ $webinar->titulo }}</h5>
                <p class="text-muted small mb-1">
                    Inicia el {{ \Carbon\Carbon::parse($webinar->fecha)->translatedFormat('d \d\e F \a \l\a\s h:i A') }}
                </p>
            </div>

            {{-- Mensajes flash --}}
            @if(session('error'))
                <div class="alert alert-danger text-center py-2">{{ session('error') }}</div>
            @elseif(session('success'))
                <div class="alert alert-success text-center py-2">{{ session('success') }}</div>
            @elseif(session('info'))
                <div class="alert alert-info text-center py-2">{{ session('info') }}</div>
            @endif

            <form action="{{ route('cliente.webinars.validar', $webinar->id) }}" method="POST" class="mt-3">
                @csrf

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Contraseña del webinar</label>
                    <input type="password" name="password" id="password"
                        class="form-control form-control-lg text-center @error('password') is-invalid @enderror"
                        placeholder="Ingresa la contraseña" required autofocus>
                    @error('password')
                        <div class="invalid-feedback text-center">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success w-100 fw-semibold py-2">
                    ✅ Validar y acceder
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('cliente.webinars.index') }}" class="text-decoration-none text-muted">
                    ← Volver a la lista de webinars
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
