@extends('layouts.admin')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="container py-5">

    <div class="text-center mb-5">
        <h2 class="fw-bold text-success mb-1">👥 Gestión de Usuarios</h2>
        <p class="text-muted">Activa o inactiva usuarios fácilmente desde el panel administrativo</p>
    </div>

    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-gradient-success text-white py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold">Listado de Usuarios</h5>
            <span class="badge bg-light text-success px-3 py-2">{{ $usuarios->count() }} usuarios</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-center mb-0">
                <thead class="bg-light text-success">
                    <tr>
                        <th>#</th>
                        <th class="text-start">Usuario</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $index => $usuario)
                        <tr class="fade-in-row">
                            <td>{{ $index + 1 }}</td>

                            <td class="text-start">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($usuario->email))) }}?s=60&d=identicon" 
                                         class="rounded-circle border shadow-sm user-avatar" 
                                         width="48" height="48" alt="Avatar de {{ $usuario->nombre }}">
                                    <div>
                                        <div class="fw-semibold">{{ $usuario->nombre }}</div>
                                        <small class="text-muted">{{ $usuario->email }}</small>
                                    </div>
                                </div>
                            </td>

                            <td>{{ $usuario->email }}</td>
                            <td><span class="badge bg-info text-dark">{{ ucfirst($usuario->role) }}</span></td>

                            <td>
                                @if($usuario->activo)
                                    <span class="badge bg-success px-3 py-2">Activo</span>
                                @else
                                    <span class="badge bg-secondary px-3 py-2">Inactivo</span>
                                @endif
                            </td>

                            <td>
                                <form action="{{ route('admin.usuarios.toggle', $usuario->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-sm fw-semibold shadow-sm {{ $usuario->activo ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                        {{ $usuario->activo ? 'Inactivar' : 'Activar' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.bg-gradient-success {
    background: linear-gradient(90deg, #198754, #20c997) !important;
}

.table-hover tbody tr:hover {
    background-color: #e9f7ef !important;
    transition: background-color 0.2s ease-in-out;
}

.user-avatar {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s;
}
.user-avatar:hover {
    transform: scale(1.08);
    box-shadow: 0 0 10px rgba(25, 135, 84, 0.4);
}

/* Animación de entrada */
.fade-in-row {
    animation: fadeInUp 0.5s ease forwards;
    opacity: 0;
}
@keyframes fadeInUp {
    from {
        transform: translateY(10px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>
@endsection
