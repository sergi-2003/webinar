@extends('layouts.admin')

@section('title', 'Editar Webinar')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0" style="max-width: 700px; margin: 0 auto;">
        <div class="card-body">
            <h2 class="mb-4 text-center">✏️ Editar Webinar</h2>

            {{-- Mostrar errores de validación --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Formulario --}}
            <form action="{{ route('admin.webinars.update', $webinar->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Título --}}
                <div class="mb-3">
                    <label class="form-label">Título</label>
                    <input type="text" 
                           name="titulo" 
                           class="form-control" 
                           value="{{ old('titulo', $webinar->titulo) }}" 
                           required>
                </div>

                {{-- Descripción --}}
                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" 
                              class="form-control" 
                              rows="4" 
                              required>{{ old('descripcion', $webinar->descripcion) }}</textarea>
                </div>

                {{-- Fecha y hora de inicio --}}
                <div class="mb-3">
                    <label class="form-label">Fecha y hora de inicio</label>
                    <input type="datetime-local" 
                           name="hora_inicio" 
                           class="form-control" 
                           value="{{ old('hora_inicio', \Carbon\Carbon::parse($webinar->hora_inicio)->format('Y-m-d\TH:i')) }}" 
                           required>
                    <small class="text-muted">Ejemplo: 2025-10-15T23:00</small>
                </div>

                {{-- Duración --}}
                <div class="mb-3">
                    <label class="form-label">Duración (minutos)</label>
                    <input type="number" 
                           name="duracion" 
                           class="form-control" 
                           value="{{ old('duracion', $webinar->duracion ?? 60) }}" 
                           min="1" 
                           required>
                </div>

                {{-- Estado --}}
                <div class="mb-3">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select" required>
                        <option value="proximo" {{ $webinar->estado == 'proximo' ? 'selected' : '' }}>Próximo</option>
                        <option value="en_vivo" {{ $webinar->estado == 'en_vivo' ? 'selected' : '' }}>En vivo</option>
                        <option value="finalizado" {{ $webinar->estado == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                    </select>
                </div>

                {{-- Enlace de reunión --}}
                <div class="mb-3">
                    <label class="form-label">Enlace de la reunión</label>
                    <input type="url" 
                           name="video_url" 
                           class="form-control" 
                           value="{{ old('video_url', $webinar->video_url) }}" 
                           readonly>
                    <small class="text-muted">Este enlace fue generado automáticamente al crear el webinar.</small>
                </div>

                {{-- Contraseña (opcional) --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña (opcional)</label>
                    <input type="text" 
                           name="password" 
                           id="password" 
                           class="form-control" 
                           placeholder="Dejar vacío si no desea cambiarla" 
                           value="{{ old('password', $webinar->password ?? '') }}">
                </div>

                {{-- Botones --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.webinars.index') }}" class="btn btn-secondary">
                        ⬅ Volver
                    </a>
                    <button type="submit" class="btn btn-success">
                        💾 Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
