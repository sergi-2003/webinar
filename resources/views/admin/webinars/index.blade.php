@extends('layouts.app')

@section('title', 'Panel de Webinars')

@section('content')
<style>
    body {
        background: #f8fafc;
        font-family: 'Inter', sans-serif;
    }

    .dashboard-container {
        padding: 40px 30px;
        min-height: 100vh;
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .header-section h2 {
        font-weight: 700;
        font-size: 1.9rem;
        color: #0f172a;
    }

    .btn-primary {
        background: linear-gradient(135deg, #0ea5a3, #3b82f6);
        color: #fff;
        padding: 10px 18px;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(14,165,163,0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(14,165,163,0.4);
    }

    .filter-bar {
        display: flex;
        gap: 12px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    .filter-btn {
        background: #e2e8f0;
        border: none;
        padding: 8px 14px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        color: #475569;
        transition: 0.2s;
        text-decoration: none;
    }

    .filter-btn.active,
    .filter-btn:hover {
        background: #0ea5a3;
        color: #fff;
    }

    .webinar-table {
        width: 100%;
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 6px 16px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .webinar-header {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr 1fr;
        background: #f1f5f9;
        font-weight: 700;
        color: #334155;
        padding: 14px 20px;
        font-size: 0.95rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .webinar-row {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr 1fr;
        align-items: center;
        padding: 14px 20px;
        border-bottom: 1px solid #e2e8f0;
        transition: background 0.2s;
    }

    .webinar-row:hover {
        background: #f9fafb;
    }

    .webinar-title {
        font-weight: 600;
        color: #0f172a;
    }

    .webinar-meta {
        color: #475569;
        font-size: 0.9rem;
    }

    .estado {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: capitalize;
    }

    .estado.proximo { background: #dbeafe; color: #1e3a8a; }
    .estado.en_vivo { background: #dcfce7; color: #166534; }
    .estado.finalizado { background: #fee2e2; color: #991b1b; }

    .actions {
        display: flex;
        gap: 6px;
    }

    .btn-icon {
        border: none;
        padding: 8px 10px;
        border-radius: 8px;
        font-size: 1rem;
        cursor: pointer;
        color: #fff;
        transition: 0.2s;
    }

    .btn-view { background: #0ea5a3; }
    .btn-view:hover { background: #0d9488; }

    .btn-edit { background: #3b82f6; }
    .btn-edit:hover { background: #2563eb; }

    .btn-delete { background: #ef4444; }
    .btn-delete:hover { background: #dc2626; }

    @media (max-width: 800px) {
        .webinar-header, .webinar-row {
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
        }
        .webinar-meta.hide-mobile {
            display: none;
        }
    }
</style>

<div class="dashboard-container">
    <div class="header-section">
        <h2>🎓 Panel de Webinars</h2>
        <a href="{{ route('admin.webinars.create') }}" class="btn-primary">+ Nuevo Webinar</a>
    </div>

    {{-- FILTROS FUNCIONALES --}}
    <div class="filter-bar">
        <a href="{{ route('admin.webinars.index') }}"
           class="filter-btn {{ request('estado') ? '' : 'active' }}">Todos</a>

        <a href="{{ route('admin.webinars.index', ['estado' => 'proximo']) }}"
           class="filter-btn {{ request('estado')=='proximo' ? 'active' : '' }}">Próximos</a>

        <a href="{{ route('admin.webinars.index', ['estado' => 'en_vivo']) }}"
           class="filter-btn {{ request('estado')=='en_vivo' ? 'active' : '' }}">En vivo</a>

        <a href="{{ route('admin.webinars.index', ['estado' => 'finalizado']) }}"
           class="filter-btn {{ request('estado')=='finalizado' ? 'active' : '' }}">Finalizados</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($webinars->isEmpty())
        <p class="text-center text-muted mt-4">No hay webinars registrados aún.</p>
    @else
        <div class="webinar-table">
            <div class="webinar-header">
                <span>Título</span>
                <span>Fecha</span>
                <span>Creador</span>
                <span>Estado</span>
                <span>Acciones</span>
            </div>

            @foreach ($webinars as $webinar)
                <div class="webinar-row">
                    <div class="webinar-title">
                        {{ $webinar->titulo }}
                        <div class="webinar-meta hide-mobile">
                            {{ Str::limit($webinar->descripcion, 60) }}
                        </div>
                    </div>
                    <div class="webinar-meta">
                        {{ \Carbon\Carbon::parse($webinar->fecha)->format('d/m/Y H:i') }}
                    </div>
                    <div class="webinar-meta">
                        {{ $webinar->creador->nombre ?? 'Desconocido' }}
                    </div>
                    <div>
                        <span class="estado {{ $webinar->estado }}">
                            {{ ucfirst($webinar->estado) }}
                        </span>
                    </div>
                    <div class="actions">
                        <a href="{{ $webinar->video_url }}" target="_blank" class="btn-icon btn-view" title="Ver">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('admin.webinars.edit', $webinar->id) }}" class="btn-icon btn-edit" title="Editar">
                            <i class="bi bi-pencil-square"></i>
                        </a>
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
            title: '¿Eliminar webinar?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0ea5a3',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
});
</script>
@endsection
