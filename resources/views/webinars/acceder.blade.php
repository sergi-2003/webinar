@extends('layouts.app')

@section('title', 'Acceder al webinar')

@section('content')
<div class="container py-5" style="max-width: 500px;">
    <div class="card shadow p-4">
        <h4 class="text-center mb-4">🔒 Acceso privado</h4>

        <p class="text-center mb-3">
            El webinar <strong>{{ $webinar->titulo }}</strong> requiere una contraseña.
        </p>

        @if (session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('cliente.webinars.validar', $webinar->id) }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Contraseña:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
        </form>
    </div>
</div>
@endsection
