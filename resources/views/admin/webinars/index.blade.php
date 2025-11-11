@extends('layouts.admin')

@section('title', 'Panel de Administración de Webinars')

@section('content')
<style>
:root {
    --primary-color: #10b981;
    --primary-dark: #059669;
    --secondary-color: #3b82f6;
    --secondary-dark: #2563eb;
    --danger-color: #ef4444;
    --warning-color: #f59e0b;
    --bg-light: #f9fafb;
    --bg-white: #ffffff;
    --text-dark: #1f2937;
    --text-muted: #6b7280;
    --radius: 10px;
}

/* === BASE GENERAL === */
body {
    background: var(--bg-light);
    font-family: 'Inter', sans-serif;
    color: var(--text-dark);
    line-height: 1.6;
}

.dashboard-container {
    padding: 40px 20px;
    max-width: 1200px;
    margin: 0 auto;
}

/* === HEADER === */
.header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 15px;
}

.header-section h2 {
    font-weight: 800;
    font-size: 2rem;
    color: var(--text-dark);
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-create {
    background: var(--primary-color);
    color: #fff;
    padding: 12px 24px;
    border-radius: var(--radius);
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s ease;
    box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);
}

.btn-create:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

/* === FILTROS === */
.filter-bar {
    display: flex;
    gap: 10px;
    margin-bottom: 25px;
    padding: 10px;
    background: #fff;
    border-radius: var(--radius);
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    overflow-x: auto;
}

.filter-btn {
    background: #f3f4f6;
    border: none;
    padding: 8px 18px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    color: var(--text-muted);
    transition: 0.2s;
    text-decoration: none;
    white-space: nowrap;
}

.filter-btn.active,
.filter-btn:hover {
    background: var(--secondary-color);
    color: #fff;
}

/* === TABLA === */
.webinar-table {
    width: 100%;
    background: var(--bg-white);
    border-radius: var(--radius);
    box-shadow: 0 6px 20px rgba(0,0,0,0.05);
    overflow: hidden;
    border: 1px solid #e5e7eb;
}

.webinar-header {
    display: grid;
    grid-template-columns: 2.5fr 1fr 1fr 1fr 1.5fr;
    background: #f3f4f6;
    font-weight: 700;
    color: var(--text-muted);
    padding: 16px 20px;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

.webinar-row {
    display: grid;
    grid-template-columns: 2.5fr 1fr 1fr 1fr 1.5fr;
    align-items: center;
    padding: 18px 20px;
    border-top: 1px solid #f1f2f4;
    transition: background 0.2s, transform 0.15s;
}

.webinar-row:hover {
    background: #f9fafb;
    transform: scale(1.01);
}

.webinar-title {
    font-weight: 700;
    color: var(--text-dark);
    font-size: 1rem;
}

.webinar-meta {
    color: var(--text-muted);
    font-size: 0.85rem;
    margin-top: 4px;
}

/* === ESTADOS === */
.estado {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
}

.estado.proximo { background: #e0f2fe; color: #0369a1; }
.estado.en_vivo { background: #d1fae5; color: #065f46; }
.estado.finalizado { background: #fee2e2; color: #991b1b; }

/* === ACCIONES === */
.actions {
    display: flex;
    gap: 10px;
    align-items: center;
    justify-content: flex-end;
    flex-wrap: wrap;
}

.btn-icon {
    border: none;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    font-size: 1rem;
    cursor: pointer;
    color: #fff;
    transition: all 0.2s;
}

.btn-icon:hover {
    transform: scale(1.05);
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.btn-view { background: #0ea5e9; }
.btn-edit { background: var(--secondary-color); }
.btn-delete { background: var(--danger-color); }

/* === RESPONSIVE === */
@media (max-width: 992px) {
    .webinar-header, .webinar-row {
        grid-template-columns: 2fr 1fr 1fr 1.5fr;
    }
    .webinar-meta.hide-mobile {
        display: none;
    }
}

@media (max-width: 768px) {
    .webinar-header {
        display: none;
    }

    .webinar-row {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 16px;
        border-radius: var(--radius);
        border: 1px solid #e5e7eb;
        box-shadow: 0 3px 8px rgba(0,0,0,0.03);
        background: #fff;
        padding: 18px;
    }

    .webinar-title {
        font-size: 1.05rem;
        margin-bottom: 6px;
    }

    .webinar-meta {
        margin-bottom: 8px;
    }

    .webinar-row > div {
        width: 100%;
        margin-bottom: 8px;
    }

    .estado {
        font-size: 0.8rem;
    }

    .actions {
        justify-content: flex-start;
    }

    .actions .btn-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
    }
}
</style>

<div class="dashboard-container">
    <div class="header-section">
        <h2>🗓️ Panel de Gestión de Webinars</h2>
        <a href="{{ route('admin.webinars.create') }}" class="btn-create">
            <i class="bi bi-plus-circle-fill"></i> Crear Nuevo Webinar
        </a>
    </div>
    
    {{-- BARRA DE FILTROS --}}
    <div class="filter-bar">
        <a href="{{ route('admin.webinars.index') }}"
           class="filter-btn {{ request('estado') ? '' : 'active' }}">Todos ({{ $webinars->total() ?? '0' }})</a>

        <a href="{{ route('admin.webinars.index', ['estado' => 'proximo']) }}"
           class="filter-btn {{ request('estado')=='proximo' ? 'active' : '' }}">Próximos</a>

        <a href="{{ route('admin.webinars.index', ['estado' => 'en_vivo']) }}"
           class="filter-btn {{ request('estado')=='en_vivo' ? 'active' : '' }}">En Vivo</a>

        <a href="{{ route('admin.webinars.index', ['estado' => 'finalizado']) }}"
           class="filter-btn {{ request('estado')=='finalizado' ? 'active' : '' }}">Finalizados</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($webinars->isEmpty())
        <p class="text-center text-muted mt-4">
            No se encontraron webinars con este filtro. ¡Crea uno!
        </p>
    @else
        <div class="webinar-table">
            <div class="webinar-header">
                <span>Título / Descripción</span>
                <span>Fecha y Hora</span>
                <span>Creador</span>
                <span>Estado</span>
                <span>Acciones</span>
            </div>

            @foreach ($webinars as $webinar)
                <div class="webinar-row">
                    
                    {{-- 🔹 Título y descripción --}}
                    <div class="webinar-title">
                        {{ $webinar->titulo }}

                        {{-- 🔒 Indicador de privacidad --}}
                        @if($webinar->privado)
                            <span class="badge bg-danger ms-2" style="font-size:0.75rem;">
                                <i class="bi bi-lock-fill"></i> Privado
                            </span>
                        @else
                            <span class="badge bg-success ms-2" style="font-size:0.75rem;">
                                <i class="bi bi-globe"></i> Público
                            </span>
                        @endif

                        <div class="webinar-meta hide-mobile">
                            {{ Str::limit($webinar->descripcion, 80) }}
                        </div>
                    </div>

                    {{-- 🔹 Fecha --}}
                    <div class="webinar-meta">
                        <i class="bi bi-calendar-event"></i>
                        {{ \Carbon\Carbon::parse($webinar->fecha)->format('d/m/Y H:i') }}
                    </div>

                    {{-- 🔹 Creador --}}
                    <div class="webinar-meta">
                        <i class="bi bi-person-circle"></i>
                        {{ $webinar->creador->nombre ?? 'Sistema' }}
                    </div>

                    {{-- 🔹 Estado --}}
                    <div>
                        <span class="estado {{ $webinar->estado }}">
                            {{ ucfirst(str_replace('_', ' ', $webinar->estado)) }}
                        </span>
                        @if($webinar->activo)
                            <div class="mt-1" style="font-size:0.8rem; color:#059669;">
                                <i class="bi bi-check-circle-fill"></i> Activo
                            </div>
                        @else
                            <div class="mt-1" style="font-size:0.8rem; color:#b91c1c;">
                                <i class="bi bi-x-circle-fill"></i> Inactivo
                            </div>
                        @endif
                    </div>

                    {{-- 🔹 Acciones --}}
                    <div class="actions">
                        <a href="{{ route('admin.webinars.acceder', $webinar->id) }}" class="btn-icon btn-view" title="Ver Detalles">
                            <i class="bi bi-eye"></i>
                        </a>

                        <a href="{{ route('admin.webinars.inscritos', $webinar->id) }}" class="btn-icon btn-view" title="Ver Inscritos">
                            <i class="bi bi-people-fill"></i>
                        </a>

                        <a href="{{ route('admin.webinars.edit', $webinar->id) }}" class="btn-icon btn-edit" title="Editar">
                            <i class="bi bi-pencil-square"></i>
                        </a>

                        <form action="{{ route('admin.webinars.toggle', $webinar->id) }}" method="POST" class="d-inline toggle-form">
                            @csrf
                            @method('PATCH')
                            @if($webinar->activo)
                                <button type="submit" class="btn-icon" style="background:var(--warning-color);" title="Inactivar Webinar">
                                    <i class="bi bi-power"></i>
                                </button>
                            @else
                                <button type="submit" class="btn-icon" style="background:var(--primary-color);" title="Activar Webinar">
                                    <i class="bi bi-play-fill"></i>
                                </button>
                            @endif
                        </form>

                        <form action="{{ route('admin.webinars.destroy', $webinar->id) }}" method="POST" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon btn-delete" title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Eliminarás este webinar y sus registros de inscripción. Esta acción es irreversible.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--primary-color)',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(result => {
            if (result.isConfirmed) this.submit();
        });
    });
});

document.querySelectorAll('.toggle-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const isActive = this.querySelector('button i').classList.contains('bi-power');
        Swal.fire({
            title: isActive ? '¿Inactivar webinar?' : '¿Activar webinar?',
            text: isActive
                ? "Los usuarios ya no podrán ingresar a esta reunión."
                : "Los usuarios podrán ingresar nuevamente a esta reunión.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: 'var(--primary-color)',
            cancelButtonColor: '#ef4444',
            confirmButtonText: isActive ? 'Sí, inactivar' : 'Sí, activar',
            cancelButtonText: 'Cancelar'
        }).then(result => {
            if (result.isConfirmed) this.submit();
        });
    });
});
</script>
@endsection
