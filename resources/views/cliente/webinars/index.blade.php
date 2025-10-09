@extends('layouts.app')

@section('title', 'Panel de Webinars')

@section('content')
<div class="container py-5">

    <!-- ENCABEZADO -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
        <div>
            <h1 class="fw-bold text-success mb-2 display-6">Panel de Webinars</h1>
            <p class="text-muted fs-5">Consulta, participa y mantente actualizado con los webinars institucionales.</p>
        </div>

        <!-- BÚSQUEDA Y FILTROS -->
        <form id="filtrosForm" method="GET" action="{{ route('cliente.webinars.index') }}" 
              class="d-flex flex-wrap gap-2 mt-3 mt-md-0 bg-white p-3 rounded-4 shadow-sm">
            
            <div class="input-group">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar webinar..." 
                       class="form-control rounded-start-pill border-0 bg-light px-3" style="min-width: 220px;">
                <select name="estado" class="form-select border-0 bg-light px-3">
                    <option value="">Todos</option>
                    <option value="proximo" {{ request('estado') == 'proximo' ? 'selected' : '' }}>Próximos</option>
                    <option value="en_vivo" {{ request('estado') == 'en_vivo' ? 'selected' : '' }}>En vivo</option>
                    <option value="finalizado" {{ request('estado') == 'finalizado' ? 'selected' : '' }}>Finalizados</option>
                </select>
                <button class="btn btn-success px-4 rounded-end-pill">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- LISTA DE WEBINARS -->
    <div id="webinar-lista">
        @include('cliente.webinars.partials.lista')
    </div>

</div>

<!-- ESTILOS PERSONALIZADOS -->
<style>
/* ===== TARJETAS ===== */
.dashboard-card {
    transition: all 0.3s ease;
    background: #ffffff;
    border-top: 5px solid #198754 !important;
    border-radius: 1rem !important;
}
.dashboard-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
}

/* ===== TEXTOS ===== */
h1 {
    font-size: 2.2rem;
}
p.text-muted.fs-5 {
    max-width: 550px;
}

/* ===== FORMULARIO DE FILTROS ===== */
#filtrosForm {
    border-left: 4px solid #198754;
}
.form-control, .form-select {
    background-color: #f8f9fa !important;
    transition: all 0.3s ease;
}
.form-control:focus, .form-select:focus {
    background-color: #fff;
    box-shadow: 0 0 0 2px rgba(25,135,84,0.2);
}

/* ===== BOTONES ===== */
.btn-success {
    background-color: #198754 !important;
    border: none;
    transition: all 0.25s ease;
}
.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(25,135,84,0.3);
}

/* ===== BADGES ===== */
.badge {
    font-weight: 600;
    letter-spacing: 0.4px;
    border-radius: 2rem;
    padding: 0.4em 1em;
}
</style>

<!-- AOS -->
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

<!-- AJAX -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    AOS.init({ duration: 700, once: true });

    const form = document.getElementById('filtrosForm');
    const lista = document.getElementById('webinar-lista');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        const formData = new FormData(form);
        const params = new URLSearchParams(formData).toString();

        const response = await fetch(`?${params}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        const html = await response.text();

        lista.innerHTML = html;
        AOS.refresh();
    });
});
</script>
@endsection
