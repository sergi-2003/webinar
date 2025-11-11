@extends('layouts.admin')

@section('title', 'Participantes del Webinar')

@section('content')
<div class="container py-5">

    <!-- 🧠 ENCABEZADO -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-success">{{ $webinar->titulo }}</h2>
        <p class="text-muted fs-5 mb-0">Listado de participantes inscritos</p>
    </div>

    <!-- 🌿 TARJETAS DE ESTADÍSTICAS -->
    <div class="row g-4 mb-5">
        <div class="col-md-3 col-sm-6">
            <div class="card shadow border-0 rounded-4 bg-gradient-success text-white text-center p-4">
                <i class="bi bi-person-check fs-2 mb-2"></i>
                <h3 class="fw-bold">{{ $webinar->inscripciones->count() }}</h3>
                <p class="mb-0">Inscritos Totales</p>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow border-0 rounded-4 bg-gradient-info text-white text-center p-4">
                <i class="bi bi-calendar-event fs-2 mb-2"></i>
                <h4 class="fw-bold">{{ \Carbon\Carbon::parse($webinar->fecha)->format('d/m/Y') }}</h4>
                <p class="mb-0">Fecha</p>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow border-0 rounded-4 bg-gradient-warning text-white text-center p-4">
                <i class="bi bi-clock-history fs-2 mb-2"></i>
                <h4 class="fw-bold">{{ \Carbon\Carbon::parse($webinar->hora_inicio)->format('H:i') }}</h4>
                <p class="mb-0">Hora de Inicio</p>
            </div>
        </div>

        
    </div>

    <!-- 👥 TABLERO DE PARTICIPANTES -->
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-gradient-success text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h5 class="fw-semibold mb-0">👥 Listado de Participantes</h5>
            <span class="badge bg-light text-success fs-6">
                {{ $webinar->inscripciones->count() }} Inscrito{{ $webinar->inscripciones->count() != 1 ? 's' : '' }}
            </span>
        </div>

        @if($webinar->inscripciones->isEmpty())
            <div class="p-5 text-center text-muted">
                <i class="bi bi-people display-5 d-block mb-3"></i>
                <p class="fs-5 mb-0">Aún no hay participantes registrados en este webinar.</p>
            </div>
        @else
            <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
                <table class="table table-hover align-middle text-center mb-0">
                    <thead class="bg-light sticky-top shadow-sm">
                        <tr>
                            <th>Avatar</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Fecha de Inscripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($webinar->inscripciones as $inscripcion)
                            @php
                                $usuario = $inscripcion->usuario;
                                $foto = "https://api.dicebear.com/9.x/adventurer/svg?seed=" . urlencode($usuario->nombre ?? 'User');
                            @endphp
                            <tr class="{{ $loop->even ? 'bg-light' : '' }}">
                                <td><img src="{{ $foto }}" class="rounded-circle shadow-sm" width="50" height="50" alt="avatar"></td>
                                <td class="fw-semibold">{{ $usuario->nombre ?? 'Desconocido' }}</td>
                                <td class="text-muted">{{ $usuario->email ?? 'Sin correo' }}</td>
                                <td>
                                    <span class="badge bg-success-subtle text-success fw-semibold px-3 py-2">
                                        {{ \Carbon\Carbon::parse($inscripcion->fecha_inscripcion)->format('d/m/Y H:i') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- 🔙 BOTÓN VOLVER -->
    <div class="text-center mt-4">
        <a href="{{ route('admin.webinars.index') }}" class="btn btn-outline-success rounded-pill px-4">
            ⬅ Volver al panel
        </a>
    </div>
</div>

<!-- 🌿 ESTILOS PERSONALIZADOS -->
<style>
    .bg-gradient-success {
        background: linear-gradient(90deg, #198754 0%, #20c997 100%) !important;
    }

    .bg-gradient-info {
        background: linear-gradient(90deg, #0dcaf0, #0d6efd) !important;
    }

    .bg-gradient-warning {
        background: linear-gradient(90deg, #ffc107, #fd7e14) !important;
    }

    .bg-gradient-danger {
        background: linear-gradient(90deg, #dc3545, #ff6384) !important;
    }

    .table-hover tbody tr:hover {
        background-color: #e9f7ef !important;
        transition: all 0.2s ease-in-out;
    }

    .card-header {
        background: linear-gradient(90deg, #198754, #20c997);
    }
</style>
@endsection
