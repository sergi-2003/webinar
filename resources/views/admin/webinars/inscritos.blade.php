@extends('layouts.admin')

@section('title', 'Participantes del Webinar')

@section('content')
<div class="dashboard-bg py-5">
    <div class="container">

        <!-- ENCABEZADO MEJORADO -->
        <div class="text-center mb-5">
            <h1 class="fw-bold text-dark mb-2">
                <i class="bi bi-broadcast text-primary me-2"></i> {{ $webinar->titulo }}
            </h1>
            <p class="text-muted fs-5 mb-0">Panel de participantes y estadísticas del webinar</p>
        </div>

        <!-- LISTADO DE PARTICIPANTES (NO SE TOCA) -->
        @if($webinar->inscripciones->isEmpty())
            <div class="alert alert-warning border-0 shadow-sm rounded-4 text-center p-5">
                <i class="bi bi-emoji-frown fs-1 d-block mb-3 text-secondary"></i>
                <h4 class="fw-bold">No hay participantes inscritos</h4>
                <p class="text-muted mb-0">Cuando alguien se registre, aparecerá aquí.</p>
            </div>
        @else
            <div class="card border-0 rounded-4 shadow-lg overflow-hidden mb-4">
                <div class="card-header bg-success text-white fw-bold fs-5 py-3">
                    <i class="bi bi-table me-2"></i>Listado de Participantes
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light text-center">
                            <tr>
                                <th>Avatar</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Fecha de Inscripción</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($webinar->inscripciones as $inscripcion)
                                @php
                                    $usuario = $inscripcion->usuario;
                                    $foto = "https://api.dicebear.com/9.x/adventurer/svg?seed=" . urlencode($usuario->nombre ?? 'User');
                                @endphp
                                <tr class="hover-row">
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
            </div>
            <!-- 🔙 BOTÓN VOLVER -->
    <div class="text-center mt-4">
        <a href="{{ route('admin.webinars.index') }}" class="btn btn-outline-success rounded-pill px-4">
            ⬅ Volver al panel
        </a>
    </div>
        @endif
    </div>
</div>

<!-- ESTILOS -->
@push('styles')
<style>
    .dashboard-bg {
        background: linear-gradient(180deg, #f8fafc 0%, #eef9f2 100%);
        min-height: 100vh;
    }

    .card-tile {
        transition: all 0.3s ease;
    }

    .card-tile:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .icon-circle {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(255,255,255,0.3);
    }

    .bg-gradient-green {
        background: linear-gradient(135deg, #198754, #20c997);
    }

    .bg-gradient-blue {
        background: linear-gradient(135deg, #0dcaf0, #0d6efd);
    }

    .bg-gradient-orange {
        background: linear-gradient(135deg, #ffc107, #fd7e14);
    }

    .bg-gradient-pink {
        background: linear-gradient(135deg, #dc3545, #ff6b81);
    }

    .hover-row:hover {
        background-color: rgba(25, 135, 84, 0.1);
        transition: background-color 0.3s;
    }

    .table {
        font-size: 0.95rem;
    }

    .table thead th {
        font-weight: 600;
    }
</style>
@endpush
@endsection
