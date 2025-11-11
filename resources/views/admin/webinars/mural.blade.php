@extends('layouts.app')

@section('title', 'Mural de Grabaciones')

@section('content')
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

<div class="container py-5">
    <!-- 🎥 ENCABEZADO -->
    <div class="text-center mb-5" data-aos="fade-down">
        <h1 class="fw-bold text-success display-5 mb-3">🎬 Mural de Grabaciones</h1>
        <p class="text-muted fs-5 mb-0">Explora las grabaciones de nuestros webinars finalizados.</p>
        <div class="mx-auto mt-3" style="width:100px; height:4px; background:linear-gradient(90deg, #198754, #20c997); border-radius:10px;"></div>
    </div>

    <!-- 🎞 LISTA DE GRABACIONES -->
    <div data-aos="fade-up">
        @if ($webinars->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-collection-play display-1 text-muted"></i>
                <h4 class="mt-3 fw-semibold">Aún no hay grabaciones disponibles</h4>
                <p class="text-muted">Cuando los webinars finalicen, aparecerán aquí.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach ($webinars as $webinar)
                    <div class="col-12 col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 80 }}">
                        <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden">
                            <!-- Imagen o fondo -->
                            <div class="position-relative bg-success bg-opacity-10 p-4 text-center">
                                <i class="bi bi-play-circle-fill text-success" style="font-size: 3rem;"></i>
                                <span class="badge bg-secondary position-absolute top-0 start-0 m-3">Finalizado</span>
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h5 class="fw-bold text-dark">{{ $webinar->titulo }}</h5>
                                <p class="text-muted small mb-2">
                                    <i class="bi bi-calendar-event me-1"></i>
                                    {{ \Carbon\Carbon::parse($webinar->fecha)->format('d/m/Y H:i') }}
                                </p>
                                <p class="text-secondary flex-grow-1">{{ Str::limit($webinar->descripcion, 120) }}</p>

                                <div class="mt-3 d-grid">
                                    <a href="{{ $webinar->video_url }}" 
                                       target="_blank" 
                                       class="btn btn-outline-success rounded-pill fw-semibold">
                                        <i class="bi bi-box-arrow-up-right me-1"></i> Ver grabación
                                    </a>
                                </div>
                            </div>

                            <div class="card-footer bg-light text-center border-0 py-3">
                                <small class="text-muted">
                                    <i class="bi bi-person-circle me-1"></i>
                                    {{ $webinar->organizador ?? 'Administrador' }}
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<!-- 🎨 ESTILOS -->
<style>
.card {
    transition: all 0.3s ease;
}
.card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
.badge {
    border-radius: 25px;
    font-size: 0.8rem;
    padding: 0.4em 0.8em;
}
</style>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => AOS.init({ duration: 700, once: true }));
</script>
@endsection
