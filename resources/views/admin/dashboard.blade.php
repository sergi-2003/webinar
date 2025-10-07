@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')
<style>
    body {
        background: #f1f5f9;
        font-family: 'Inter', sans-serif;
    }

    .dashboard-container {
        padding: 40px 30px;
        min-height: 100vh;
    }

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 35px;
    }

    .dashboard-header h2 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #0f172a;
    }

    .filter-select {
        background: white;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 0.95rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        padding: 25px;
        position: relative;
        overflow: hidden;
        transition: all 0.25s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.08);
    }

    .stat-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        height: 5px;
        width: 100%;
        background: linear-gradient(90deg, #0ea5a3, #3b82f6);
        border-radius: 16px 16px 0 0;
    }

    .stat-icon {
        font-size: 2.3rem;
        color: #0ea5a3;
        margin-bottom: 10px;
    }

    .stat-title {
        color: #64748b;
        font-size: 0.95rem;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1e293b;
    }

    .charts-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 25px;
        margin-bottom: 35px;
    }

    .chart-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .chart-card h5 {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 15px;
    }

    .recent-activity {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .recent-activity h5 {
        font-weight: 600;
        margin-bottom: 15px;
    }

    .activity-item {
        border-bottom: 1px solid #e2e8f0;
        padding: 10px 0;
        display: flex;
        justify-content: space-between;
    }

    .activity-item:last-child { border-bottom: none; }

    .activity-item span {
        color: #475569;
        font-size: 0.95rem;
    }

    .btn-primary {
        background-color: #0ea5a3;
        border: none;
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 600;
        transition: 0.2s;
    }

    .btn-primary:hover {
        background-color: #0c9694;
    }

    @media (max-width: 992px) {
        .charts-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dashboard-container">
    {{-- Header --}}
    <div class="dashboard-header">
        <h2>📊 Panel de Administración</h2>
        <select class="filter-select" id="filterSelect">
            <option>Últimos 6 meses</option>
            <option>Último año</option>
            <option>Último trimestre</option>
        </select>
    </div>

    {{-- Métricas principales --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-camera-video"></i></div>
            <div class="stat-title">Webinars Totales</div>
            <div class="stat-value">{{ $totalWebinars }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="color:#3b82f6;"><i class="bi bi-broadcast"></i></div>
            <div class="stat-title">Webinars Activos</div>
            <div class="stat-value">{{ $activeWebinars }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="color:#f97316;"><i class="bi bi-stopwatch"></i></div>
            <div class="stat-title">Webinars Finalizados</div>
            <div class="stat-value">{{ $inactiveWebinars ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="color:#22c55e;"><i class="bi bi-people"></i></div>
            <div class="stat-title">Usuarios Registrados</div>
            <div class="stat-value">{{ $totalUsers }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="color:#a855f7;"><i class="bi bi-check-circle"></i></div>
            <div class="stat-title">Total Inscripciones</div>
            <div class="stat-value">{{ $totalInscripciones }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="color:#facc15;"><i class="bi bi-graph-up"></i></div>
            <div class="stat-title">Promedio Asistentes / Webinar</div>
            <div class="stat-value">{{ number_format($promedioAsistentes, 1) }}</div>
        </div>
    </div>

    {{-- Gráficas --}}
    <div class="charts-grid">
        <div class="chart-card">
            <h5>📈 Tendencia de creación de webinars</h5>
            <canvas id="lineChart"></canvas>
        </div>
        <div class="chart-card">
            <h5>🥧 Estado actual de webinars</h5>
            <canvas id="pieChart"></canvas>
        </div>
    </div>

    {{-- Actividad reciente --}}
    <div class="recent-activity">
        <h5>🕒 Actividad Reciente</h5>

        <h6 class="mt-3 mb-2 text-secondary">🎥 Últimos Webinars</h6>
        @forelse ($ultimosWebinars as $webinar)
            <div class="activity-item">
                <span><strong>{{ $webinar->titulo }}</strong></span>
                <span>{{ $webinar->fecha ? \Carbon\Carbon::parse($webinar->fecha)->diffForHumans() : 'Sin fecha' }}</span>
            </div>
        @empty
            <p class="text-muted">No hay webinars recientes.</p>
        @endforelse

        <h6 class="mt-4 mb-2 text-secondary">👤 Nuevos Usuarios</h6>
        @forelse ($ultimosUsuarios as $user)
            <div class="activity-item">
                <span><strong>{{ $user->name }}</strong></span>
                <span>{{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->diffForHumans() : 'Sin fecha' }}</span>
            </div>
        @empty
            <p class="text-muted">No hay usuarios nuevos.</p>
        @endforelse

        <div class="text-center mt-4">
            <a href="{{ route('admin.webinars.index') }}" class="btn btn-primary">
                📅 Gestionar Webinars
            </a>
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 📈 Línea de tendencia
    new Chart(document.getElementById('lineChart'), {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Webinars Creados',
                data: @json($data),
                backgroundColor: 'rgba(14,165,163,0.3)',
                borderColor: '#0ea5a3',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } },
            plugins: {
                legend: { display: false }
            }
        }
    });

    // 🥧 Gráfico de pastel
    new Chart(document.getElementById('pieChart'), {
        type: 'doughnut',
        data: {
            labels: ['Activos', 'Próximos', 'Finalizados'],
            datasets: [{
                data: [{{ $activeWebinars }}, {{ $proximosWebinars }}, {{ $inactiveWebinars ?? 0 }}],
                backgroundColor: ['#3b82f6', '#10b981', '#f97316'],
                hoverOffset: 10
            }]
        },
        options: {
            plugins: {
                legend: { position: 'bottom' },
                tooltip: { enabled: true }
            }
        }
    });
</script>
@endsection
