@extends('layouts.admin')

@section('title', 'Mis Conferencias')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h2 class="fw-bold text-secundary mb-0">
            <i class="bi bi-calendar2-check me-3"></i> Mis Conferencias
        </h2>
        <a href="{{ route('cliente.webinars.index') }}" class="btn btn-outline-success rounded-pill">
            <i class="bi bi-plus-circle me-1"></i> Ver nuevos webinars
        </a>
    </div>

    @if ($inscripciones->isEmpty())
        <div class="text-center py-5">
            <div class="empty-state">
                <i class="bi bi-clipboard-x"></i>
                <h4>No estás inscrito en ningún webinar</h4>
                <p>Explora los webinars disponibles e inscríbete para participar.</p>
                <a href="{{ route('cliente.webinars.index') }}" class="btn btn-success mt-3 rounded-pill">
                    <i class="bi bi-search me-1"></i> Buscar webinars
                </a>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach ($inscripciones as $inscripcion)
                @php
                    $webinar = $inscripcion->webinar;
                    $estado = strtolower($webinar->estado ?? 'proximo');
                    $estadoColor = match($estado) {
                        'en_vivo' => 'bg-danger text-white',
                        'proximo' => 'bg-info text-dark',
                        'finalizado' => 'bg-secondary text-white',
                        default => 'bg-light text-dark'
                    };
                    $estadoIcon = match($estado) {
                        'en_vivo' => 'bi-broadcast',
                        'proximo' => 'bi-hourglass-split',
                        'finalizado' => 'bi-check-circle',
                        default => 'bi-circle'
                    };

                    $fechaWebinar = \Carbon\Carbon::parse($webinar->fecha);
                    $ahora = \Carbon\Carbon::now();
                    $disponible = $ahora->greaterThanOrEqualTo($fechaWebinar);
                @endphp

                <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="webinar-card card border-0 shadow-sm h-100 overflow-hidden">
                        <div class="webinar-header position-relative">
                            <span class="badge estado {{ $estadoColor }}">
                                <i class="bi {{ $estadoIcon }} me-1"></i> {{ ucfirst($webinar->estado) }}
                            </span>
                            <div class="header-overlay"></div>
                            <i class="bi bi-camera-video-fill corner-icon"></i>
                        </div>

                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="fw-bold text-dark mb-2">{{ $webinar->titulo }}</h5>
                            <p class="text-muted small mb-3">
                                <i class="bi bi-calendar-event me-1"></i>
                                {{ $fechaWebinar->format('d/m/Y H:i') }}
                            </p>
                            <p class="text-secondary flex-grow-1">{{ Str::limit($webinar->descripcion, 100) }}</p>

                            {{-- ACCIONES --}}
                            @if ($webinar->estado === 'finalizado')
                                <button class="btn btn-outline-secondary rounded-pill fw-semibold mt-3 shadow-sm w-100" disabled>
                                    <i class="bi bi-check-circle me-1"></i> Finalizado
                                </button>
                            @else
                                <div class="d-flex flex-column gap-2 mt-3">
                                    @if ($disponible)
                                        <a href="{{ route('cliente.webinars.acceder', $webinar->id) }}"
                                           class="btn btn-primary rounded-pill fw-semibold shadow-sm w-100">
                                            <i class="bi bi-play-circle me-1"></i> Ver webinar
                                        </a>
                                    @else
                                        <button class="btn btn-outline-secondary rounded-pill fw-semibold shadow-sm w-100" disabled>
                                            <i class="bi bi-clock-history me-1"></i> Disponible el {{ $fechaWebinar->format('d/m/Y H:i') }}
                                        </button>
                                    @endif

                                    <form action="{{ route('cliente.webinars.cancelar', $inscripcion->id) }}" method="POST" class="cancel-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger rounded-pill fw-semibold shadow-sm w-100">
                                            <i class="bi bi-x-circle me-1"></i> Cancelar inscripción
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        <div class="card-footer bg-white border-0 text-center py-3">
                            <small class="text-muted">
                                <i class="bi bi-person-circle me-1"></i>
                                Creador: {{ $webinar->creador->nombre ?? 'Administrador' }}
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- SweetAlert para confirmación --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.cancel-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Cancelar inscripción?',
            text: "Perderás el acceso a este webinar.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
});
</script>

<style>
.webinar-card {
    border-radius: 1.2rem;
    background: #ffffff;
    transition: all 0.35s ease;
    overflow: hidden;
}
.webinar-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.12);
}
.webinar-header {
    height: 120px;
    background: linear-gradient(135deg, #198754, #20c997);
    position: relative;
    overflow: hidden;
}
.webinar-header .header-overlay {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: radial-gradient(circle at top left, rgba(255,255,255,0.25), transparent 70%);
}
.webinar-header .corner-icon {
    position: absolute;
    bottom: 10px;
    right: 12px;
    font-size: 2.5rem;
    color: rgba(255,255,255,0.6);
}
.estado {
    position: absolute;
    top: 12px;
    left: 12px;
    border-radius: 30px;
    padding: 0.4em 0.9em;
    font-size: 0.8rem;
    font-weight: 600;
    z-index: 2;
}
.empty-state {
    text-align: center;
}
.empty-state i {
    font-size: 4rem;
    opacity: 0.4;
    color: #adb5bd;
}
.empty-state h4 {
    margin-top: 1rem;
    font-weight: 600;
    color: #495057;
}
.empty-state p {
    color: #6c757d;
}
</style>
@endsection
