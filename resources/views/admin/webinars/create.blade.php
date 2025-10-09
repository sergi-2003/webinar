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

    textarea {
        resize: vertical;
    }

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

    .form-switch input:checked {
        background: #0ea5a3;
    }

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

    .form-switch input:checked::before {
        transform: translateX(20px);
    }

    .password-field {
        display: none;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-6px); }
        to { opacity: 1; transform: translateY(0); }
    }

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

    .btn-secondary:hover {
        background: #cbd5e1;
    }

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
            <label>Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ old('titulo') }}" required>
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" rows="4" required>{{ old('descripcion') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Fecha</label>
            <input type="datetime-local" name="fecha" class="form-control" value="{{ old('fecha') }}" required>
        </div>

        <div class="mb-3">
            <label>Estado</label>
            <select name="estado" class="form-select" required>
                <option value="proximo">Próximo</option>
                <option value="en_vivo">En vivo</option>
                <option value="finalizado">Finalizado</option>
            </select>
        </div>

        <!-- ✅ Switch para marcar como privado -->
        <div class="form-switch">
            <input type="checkbox" id="privadoSwitch">
            <label for="privadoSwitch">Webinar privado</label>
        </div>

      <div class="mb-3">
    <label class="form-label">Contraseña (opcional)</label>
    <input type="text" name="password" class="form-control" value="{{ old('password') }}">
</div>

<div class="mb-3">
    <label class="form-label">Duración (minutos)</label>
    <input type="number" name="duracion" class="form-control" value="{{ old('duracion', 60) }}" min="1">
</div>

        <button type="submit" class="btn-primary">💾 Crear Webinar</button>
        <a href="{{ route('admin.webinars.index') }}" class="btn-secondary text-center d-block mt-3">↩ Volver</a>
    </form>
</div>

<script>
    // Mostrar/ocultar campo de contraseña según el switch
    document.getElementById('privadoSwitch').addEventListener('change', function() {
        const passwordField = document.getElementById('passwordField');
        passwordField.style.display = this.checked ? 'block' : 'none';
    });
</script>
@endsection
