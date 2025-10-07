@extends('layouts.app')

@section('title', 'Lista de Webinars')

@section('content')
<style>
    body {
        background: #f1f5f9;
        font-family: 'Inter', sans-serif;
    }

    .dashboard-container {
        padding: 30px;
        min-height: 100vh;
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .header-section h2 {
        font-weight: 700;
        font-size: 1.8rem;
        color: #1e293b;
    }

    .btn-primary {
        background-color: #0ea5a3;
        color: #fff;
        padding: 10px 18px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: 0.2s;
    }

    .btn-primary:hover {
        background-color: #089c98;
    }

    .webinar-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 25px;
    }

    .webinar-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .webinar-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.12);
    }

    .webinar-card h4 {
        font-size: 1.2rem;
        color: #1e293b;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .webinar-card p {
        color: #475569;
        font-size: 0.95rem;
        margin-bottom: 15px;
    }

    .webinar-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        color: #64748b;
        margin-bottom: 10px;
    }

    .estado {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: capitalize;
        margin-bottom: 15px;
    }

    .estado.proximo { background: #dbeafe; color: #1e3a8a; }
    .estado.en_vivo { background: #dcfce7; color: #166534; }
    .estado.finalizado { background: #fee2e2; color: #991b1b; }

    .webinar-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .btn-edit {
        background-color: #3b82f6;
        color: #fff;
        padding: 8px 12px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: 0.2s;
    }

    .btn-edit:hover {
        background-color: #2563eb;
    }

    .btn-danger {
        background-color: #ef4444;
        color: #fff;
        padding: 8px 12px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-danger:hover {
        background-color: #dc2626;
    }

    .btn-link {
        color: #0ea5a3;
        font-weight: 600;
        text-decoration: none;
        transition: 0.2s;
    }

    .btn-link:hover {
        text-decoration: underline;
    }

    @media (max-width: 640px) {
        .webinar-actions {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="dashboard-container">
    <div class="header-section">
        <h2>🎬 Webinars creados</h2>
        <a href="{{ route('admin.webinars.create') }}" class="btn-primary">+ Nuevo Webinar</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($webinars->isEmpty())
        <p class="text-center text-muted mt-4">No hay webinars registrados aún.</p>
    @else
        <div class="webinar-grid">
            @foreach ($webinars as $webinar)
                <div class="webinar-card">
                    <div>
                        <h4>{{ $webinar->titulo }}</h4>
                        <p>{{ Str::limit($webinar->descripcion, 120) }}</p>

                        <div class="webinar-meta">
                            <i class="bi bi-calendar-event"></i>
                            {{ \Carbon\Carbon::parse($webinar->fecha)->format('d/m/Y H:i') }}
                        </div>

                        <div class="webinar-meta">
                            <i class="bi bi-person"></i>
                            Creado por: {{ $webinar->creador->nombre ?? 'Desconocido' }}
                        </div>

                        <span class="estado {{ $webinar->estado }}">
                            {{ ucfirst($webinar->estado) }}
                        </span>
                    </div>

                    <div class="webinar-actions">
                        <a href="{{ $webinar->video_url }}" target="_blank" class="btn-link">🔗 Entrar a la sala</a>
                        <a href="{{ route('admin.webinars.edit', $webinar->id) }}" class="btn-edit">✏️ Editar</a>
                        <form action="{{ route('admin.webinars.destroy', $webinar->id) }}" method="POST" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger">🗑 Eliminar</button>
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
            text: "Esta acción no se puede revertir",
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
