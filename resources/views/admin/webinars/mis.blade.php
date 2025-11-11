@extends('layouts.admin')

@section('title', 'Mis Conferencias')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0"><i class="bi bi-easel2 me-2"></i> Mis Conferencias</h2>
        <a href="{{ route('admin.webinars.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nueva Conferencia
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle me-2"></i> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($webinars->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-calendar-x display-4 text-muted"></i>
            <p class="mt-3 fs-5 text-muted">No tienes conferencias creadas aún.</p>
            <a href="{{ route('admin.webinars.create') }}" class="btn btn-outline-primary">
                Crear mi primera conferencia
            </a>
        </div>
    @else
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Título</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Privado</th>
                                <th>Inscritos</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($webinars as $webinar)
                                <tr>
                                    <td class="fw-semibold">{{ $webinar->titulo }}</td>
                                    <td>{{ $webinar->fecha->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if ($webinar->estado === 'activo')
                                            <span class="badge bg-success">Activo</span>
                                        @elseif ($webinar->estado === 'finalizado')
                                            <span class="badge bg-secondary">Finalizado</span>
                                        @else
                                            <span class="badge bg-warning text-dark">{{ ucfirst($webinar->estado) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($webinar->privado)
                                            <span class="badge bg-danger">Privado</span>
                                        @else
                                            <span class="badge bg-success">Público</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.webinars.inscritos', $webinar->id) }}" class="text-decoration-none">
                                            <i class="bi bi-people"></i>
                                            {{ $webinar->inscripciones->count() }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.webinars.show', $webinar->id) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.webinars.edit', $webinar->id) }}" class="btn btn-outline-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('admin.webinars.destroy', $webinar->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Eliminar esta conferencia?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
