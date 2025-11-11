@extends('layouts.admin')

@section('title', 'Crear Webinar')

@section('content')
<style>
    body {
        background: #f8fafc;
        font-family: 'Inter', sans-serif;
    }

    .form-container {
        max-width: 720px;
        margin: 40px auto;
        background: #ffffff;
        border-radius: 16px;
        padding: 30px 40px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
    }

    h2 {
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 25px;
        text-align: center;
    }

    label {
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
        display: block;
    }

    input[type="text"],
    input[type="datetime-local"],
    input[type="url"],
    input[type="number"],
    textarea,
    select {
        width: 100%;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #f9fafb;
        transition: all 0.2s ease;
    }

    input:focus,
    textarea:focus,
    select:focus {
        border-color: #0ea5a3;
        outline: none;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(14,165,163,0.15);
    }

    textarea { resize: vertical; }

    .form-switch {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 1.2rem;
    }

    .form-switch input {
        width: 42px;
        height: 22px;
        -webkit-appearance: none;
        background: #d1d5db;
        outline: none;
        border-radius: 20px;
        position: relative;
        cursor: pointer;
        transition: background 0.3s;
    }

    .form-switch input:checked { background: #0ea5a3; }
    .form-switch input::before {
        content: '';
        position: absolute;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        top: 2px;
        left: 2px;
        background: #fff;
        transition: 0.3s;
    }
    .form-switch input:checked::before { transform: translateX(20px); }

    .btn-primary {
        background: linear-gradient(135deg, #0ea5a3, #3b82f6);
        border: none;
        color: #fff;
        padding: 12px 20px;
        border-radius: 10px;
        font-weight: 600;
        transition: 0.2s;
        width: 100%;
        margin-top: 10px;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(14,165,163,0.35);
    }
    .btn-secondary {
        background: #e2e8f0;
        border: none;
        color: #334155;
        padding: 12px 20px;
        border-radius: 10px;
        font-weight: 600;
        transition: 0.2s;
        width: 100%;
        margin-top: 8px;
    }
    .btn-secondary:hover { background: #cbd5e1; }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 20px;
    }
</style>

<div class="form-container">
    <h2>🎥 Crear nuevo webinar</h2>

    @if ($errors->any())
        <div class="alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.webinars.store') }}">
        @csrf

        <div class="mb-3">
            <label for="titulo">Título</label>
            <input type="text" id="titulo" name="titulo"
                   class="form-control @error('titulo') is-invalid @enderror"
                   value="{{ old('titulo') }}" required>
            @error('titulo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion"
                      class="form-control @error('descripcion') is-invalid @enderror"
                      rows="4" required>{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="fecha">Fecha y hora del webinar</label>
            <input type="datetime-local" id="fecha" name="fecha"
                   class="form-control @error('fecha') is-invalid @enderror"
                   value="{{ old('fecha') }}" required>
            @error('fecha')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="duracion">Duración (minutos)</label>
            <input type="number" id="duracion" name="duracion"
                   class="form-control @error('duracion') is-invalid @enderror"
                   value="{{ old('duracion', 60) }}" min="1" required>
            @error('duracion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="estado">Estado</label>
            <select id="estado" name="estado" class="form-select">
                <option value="">Automático</option>
                <option value="proximo">Próximo</option>
                <option value="en_vivo">En vivo</option>
                <option value="finalizado">Finalizado</option>
            </select>
        </div>
        
                <div class="mb-3">
                    <label for="video_url" class="form-label fw-semibold">Enlace de la reunión (Meet, Zoom, Teams, etc.)</label>
                    <input type="url" id="video_url" name="video_url"
                           class="form-control @error('video_url') is-invalid @enderror"
                           placeholder="https://enlace.com/xxxx-xxxx-xxx"
                           value="{{ old('video_url') }}" require>
                    <small class="text-muted">Pega aquí el enlace generado desde tu plataforma de videollamada.</small>
                    @error('video_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

        <div class="form-switch">
            <input type="checkbox" id="privadoSwitch" name="privado" value="1" {{ old('privado') ? 'checked' : '' }}>
            <label for="privadoSwitch">Webinar privado</label>
        </div>

        <div class="mb-3" id="passwordField">
            <label for="password" class="form-label">Contraseña (solo si es privado)</label>
            <input type="text" id="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   value="{{ old('password') }}">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-primary">💾 Crear Webinar</button>
        <a href="{{ route('admin.webinars.index') }}" class="btn-secondary text-center d-block mt-3">↩ Volver</a>
    </form>
</div>

<script>
    const privadoSwitch = document.getElementById('privadoSwitch');
    const passwordField = document.getElementById('passwordField');

    function togglePassword() {
        passwordField.style.display = privadoSwitch.checked ? 'block' : 'none';
    }

    privadoSwitch.addEventListener('change', togglePassword);
    togglePassword();
</script>
@endsection
