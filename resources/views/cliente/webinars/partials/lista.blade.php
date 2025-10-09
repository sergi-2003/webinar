@if ($webinars->isEmpty())
    <div class="text-center py-5">
        <div class="empty-state">
            <i class="bi bi-camera-video-off"></i>
            <h4>No hay webinars disponibles</h4>
            <p>Revisa más tarde para encontrar nuevos eventos en línea.</p>
        </div>
    </div>
@else
    <div class="row g-4">
        @foreach ($webinars as $webinar)
            @php
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
                            {{ \Carbon\Carbon::parse($webinar->fecha)->format('d/m/Y H:i') }}
                        </p>
                        <p class="text-secondary flex-grow-1">{{ Str::limit($webinar->descripcion, 100) }}</p>

                        @if ($webinar->password)
                            <a href="{{ route('cliente.webinars.acceder', $webinar->id) }}" 
                               class="btn btn-outline-warning rounded-pill fw-semibold mt-3 shadow-sm w-100">
                                <i class="bi bi-lock-fill me-1"></i> Acceder (Privado)
                            </a>
                        @else
                            <a href="{{ $webinar->video_url }}" target="_blank" 
                               class="btn btn-success rounded-pill fw-semibold mt-3 shadow-sm w-100">
                                <i class="bi bi-play-circle me-1"></i> Ver Webinar
                            </a>
                        @endif
                    </div>

                    <div class="card-footer bg-white border-0 text-center py-3">
                        <small class="text-muted">
                            <i class="bi bi-person-circle me-1"></i>
                           Creador:  {{ $webinar->creador->nombre ?? 'Administrador' }}
                        </small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<!-- ======== ESTILOS ======== -->
<style>
/* === TARJETAS === */
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

/* === HEADER DE TARJETA === */
.webinar-header {
    height: 120px;
    background: linear-gradient(135deg, #198754, #20c997);
    position: relative;
    overflow: hidden;
}
.webinar-header .header-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
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

/* === ESTADO VACÍO === */
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

/* === FOOTER FIJO === */
footer {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background: #198754;
    color: #fff;
    text-align: center;
    padding: 0.8rem 0;
    font-size: 0.9rem;
    z-index: 999;
    box-shadow: 0 -2px 10px rgba(0,0,0,0.15);
}
footer a {
    color: #fff;
    text-decoration: underline;
}
footer a:hover {
    text-decoration: none;
}

/* === ANIMACIÓN AOS === */
[data-aos] {
    transition: transform 0.6s ease, opacity 0.6s ease;
}
</style>

<!-- FOOTER -->
<footer>
    © {{ date('Y') }} Portal Institucional — 
    <a href="#">Términos</a> | 
    <a href="#">Privacidad</a> | 
    <a href="#">Contacto</a>
</footer>
