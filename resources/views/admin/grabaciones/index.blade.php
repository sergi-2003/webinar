@extends('layouts.admin')

@section('title', 'Administrar Grabaciones')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-success">🎬 Grabaciones Publicadas</h2>
        <a href="{{ route('admin.grabaciones.create') }}" class="btn btn-success rounded-pill">
            <i class="bi bi-plus-lg"></i> Nueva Grabación
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th>Miniatura</th>
                    <th>Título</th>
                    <th>Fecha Publicación</th>
                    <th>Publicado por</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($grabaciones as $g)
                    <tr>
                        <td>
                            @if($g->miniatura)
                                <img src="{{ asset('storage/' . $g->miniatura) }}" alt="Miniatura" width="120" class="img-thumbnail">
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $g->titulo }}</td>
                        <td>{{ $g->fecha_publicacion ? \Carbon\Carbon::parse($g->fecha_publicacion)->format('d/m/Y H:i') : '-' }}</td>
                        <td>{{ $g->usuario->nombre ?? 'Admin' }}</td>
                        <td>
                            <a href="{{ $g->video_url }}" target="_blank" class="btn btn-sm btn-outline-success">
                                Ver
                            </a>

                            <a href="{{ route('admin.grabaciones.edit', $g) }}" class="btn btn-sm btn-outline-primary">
                                Editar
                            </a>

                            <form action="{{ route('admin.grabaciones.destroy', $g) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('¿Eliminar grabación?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">No hay grabaciones publicadas</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
