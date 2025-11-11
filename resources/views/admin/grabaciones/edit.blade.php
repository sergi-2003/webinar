@extends('layouts.admin')

@section('title', 'Editar Grabación')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Editar Grabación</h2>

    <form action="{{ route('admin.grabaciones.update', $grabacion) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control @error('titulo') is-invalid @enderror" value="{{ old('titulo', $grabacion->titulo) }}" required>
            @error('titulo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="video_url" class="form-label">URL del Video</label>
            <input type="url" name="video_url" id="video_url" class="form-control @error('video_url') is-invalid @enderror" value="{{ old('video_url', $grabacion->video_url) }}" required>
            @error('video_url')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="3" class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $grabacion->descripcion) }}</textarea>
            @error('descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="miniatura" class="form-label">Miniatura (opcional)</label>
            <input type="file" name="miniatura" id="miniatura" class="form-control @error('miniatura') is-invalid @enderror">
            @error('miniatura')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if($grabacion->miniatura)
                <div class="mt-2">
                    <p>Miniatura actual:</p>
                    <img src="{{ asset('storage/' . $grabacion->miniatura) }}" alt="Miniatura" style="max-width: 200px; border-radius: 4px;">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('admin.grabaciones.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
