@extends('layouts.admin')

@section('title', 'Crear Nueva Grabación')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- Tarjeta principal --}}
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                
                {{-- ENCABEZADO con color diferente (azul degradado) --}}
                <div class="card-header text-white d-flex align-items-center justify-content-between" 
                     style="background: rgb(7, 137, 48);">
                    <h4 class="mb-0"><i class="bi bi-camera-video-fill me-2"></i> Crear Nueva Grabación</h4>
                    <a href="{{ route('admin.grabaciones.index') }}" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-arrow-left-circle"></i> Volver
                    </a>
                </div>

                {{-- CUERPO DEL FORMULARIO --}}
                <div class="card-body p-4" style="background-color: #f9fafb;">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6><i class="bi bi-exclamation-triangle-fill"></i> Se encontraron algunos errores:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.grabaciones.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Campo: Título --}}
                        <div class="mb-3">
                            <label for="titulo" class="form-label fw-bold">
                                Título <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="titulo" id="titulo"
                                   class="form-control @error('titulo') is-invalid @enderror"
                                   placeholder="Título de la Grabación"
                                   required
                                   value="{{ old('titulo') }}">
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Campo: Descripción --}}
                        <div class="mb-3">
                            <label for="descripcion" class="form-label fw-bold">Descripción</label>
                            <textarea name="descripcion" id="descripcion" rows="4"
                                      class="form-control @error('descripcion') is-invalid @enderror"
                                      placeholder="Describe brevemente la grabación...">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Campo: URL del Video --}}
                        <div class="mb-3">
                            <label for="video_url" class="form-label fw-bold">URL del Video <span class="text-danger">*</span></label>
                            <input type="url" name="video_url" id="video_url"
                                   class="form-control @error('video_url') is-invalid @enderror"
                                   placeholder="https://meet.com"
                                   required
                                   value="{{ old('video_url') }}">
                            @error('video_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Campo: Miniatura --}}
                        <div class="mb-3">
                            <label for="miniatura" class="form-label fw-bold">Miniatura (opcional)</label>
                            <input type="file" name="miniatura" id="miniatura"
                                   class="form-control @error('miniatura') is-invalid @enderror"
                                   accept="image/*">
                            @error('miniatura')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            {{-- Vista previa automática --}}
                            <div id="preview-container" class="mt-3 text-center d-none">
                                <p class="text-muted mb-2">Vista previa de la miniatura:</p>
                                <img id="preview-img" src="#" alt="Vista previa" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                            </div>
                        </div>

                        {{-- Botones --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="submit" class="btn btn-primary" style="background: rgb(7, 137, 48);">
                                <i class="bi bi-upload"></i> Publicar Grabación
                            </button>
                            <a href="{{ route('admin.grabaciones.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script para vista previa de imagen --}}
<script>
    document.getElementById('miniatura').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('preview-container');
        const previewImg = document.getElementById('preview-img');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewContainer.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('d-none');
        }
    });
</script>
@endsection

