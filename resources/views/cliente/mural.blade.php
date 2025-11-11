@extends('layouts.app')

@section('title', 'Mural de Grabaciones')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold text-success">🎬 Mural de Grabaciones</h2>

    <div class="row g-4">
        @forelse($grabaciones as $g)
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div style="width: 100%; height: 250px; overflow: hidden; border-radius: 8px 8px 0 0;">
                        <img src="{{ asset('storage/' . $g->miniatura) }}" alt="Miniatura" 
                             class="img-fluid" 
                             style="object-fit: cover; width: 100%; height: 100%;">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $g->titulo }}</h5>
                        <p class="card-text text-truncate" style="max-height: 4.5em; overflow: hidden;">
                            {{ $g->descripcion ?? 'Sin descripción' }}
                        </p>
                        <p class="card-text text-muted small mb-3">
                            Publicado: {{ \Carbon\Carbon::parse($g->fecha_publicacion)->format('d/m/Y H:i') }}
                        </p>
                        <a href="{{ $g->video_url }}" target="_blank" class="btn btn-success mt-auto">
                            Ver vídeo
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted">No hay grabaciones publicadas.</p>
        @endforelse
    </div>
</div>
@endsection
