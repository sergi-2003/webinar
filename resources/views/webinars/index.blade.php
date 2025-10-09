@extends('layouts.app')

@section('title', 'Webinars disponibles')

@section('content')
<div class="container py-5">
    <h1>PANEL WEBINAR CLIENTE</h1>
    <h2 class="mb-4 text-center fw-bold text-primary">🎥 Webinars disponibles</h2>

    @if ($webinars->isEmpty())
        <div class="text-center text-muted py-5">
            <i class="bi bi-camera-video-off" style="font-size: 3rem;"></i>
            <p class="mt-3 fs-5">No hay webinars disponibles por ahora.</p>
        </div>
    @else
        <div class="row g-4">
            @foreach ($webinars as $webinar)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-dark mb-2">
                                {{ $webinar->titulo }}
                            </h5>

                            <p class="text-muted small mb-2">
                                <i class="bi bi-calendar-event me-1"></i>
                                {{ \Carbon\Carbon::parse($webinar->fecha)->format('d/m/Y H:i') }}
                            </p>

                            <p class="card-text flex-grow-1 text-secondary">
                                {{ Str::limit($webinar->descripcion, 100) }}
                            </p>

                            @if ($webinar->password)
                                <a href="{{ route('cliente.webinars.acceder', $webinar->id) }}" 
                                   class="btn btn-warning fw-semibold w-100 mt-3 rounded-pill shadow-sm">
                                    🔒 Acceder (Privado)
                                </a>
                            @else
                                <a href="{{ $webinar->video_url }}" target="_blank" 
                                   class="btn btn-success fw-semibold w-100 mt-3 rounded-pill shadow-sm">
                                    🚀 Entrar (Público)
                                </a>
                            @endif
                        </div>

                        <div class="card-footer bg-light border-0 text-center py-3">
                            <small class="text-muted">
                                <i class="bi bi-person-circle me-1"></i>
                                {{ $webinar->creador->nombre ?? 'Administrador' }}
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
