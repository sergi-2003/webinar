@extends('layouts.app')

@section('title', 'Panel de Administración')

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

    .tab-buttons {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        border-bottom: 2px solid #e2e8f0;
    }

    .tab-btn {
        background: none;
        border: none;
        font-size: 1rem;
        font-weight: 600;
        padding: 12px 18px;
        color: #64748b;
        cursor: pointer;
        transition: 0.2s;
        border-bottom: 3px solid transparent;
    }

    .tab-btn.active {
        color: #0ea5a3;
        border-bottom-color: #0ea5a3;
    }

    .tab-content {
        display: none;
        animation: fadeIn 0.4s ease;
    }

    .tab-content.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 6px 14px rgba(0,0,0,0.05);
        padding: 30px;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 18px rgba(0,0,0,0.07);
    }

    .stat-icon {
        font-size: 2.6rem;
        margin-bottom: 10px;
    }

    .stat-title {
        color: #64748b;
        font-size: 0.95rem;
        margin-bottom: 5px;
    }

    .stat-value {
        font-size: 2rem;
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

    .recent-activity {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 6px 14px rgba(0,0,0,0.05);
    }

    .activity-item {
        border-bottom: 1px solid #e2e8f0;
        padding: 12px 0;
        display: flex;
        justify-content: space-between;
    }

    .activity-item:last-child { border-bottom: none; }

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
        .charts-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="dashboard-container">

    {{-- Tabs --}}
    <div class="tab-buttons">
        <button class="tab-btn active" data-tab="tab1">📊 Estadísticas Generales</button>
        <button class="tab-btn" data-tab="tab2">🕒 Actividad Reciente</button>
    </div>

    {{-- TAB 1 - ESTADÍSTICAS --}}
    <div id="tab1" class="tab-content active">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon text-primary"><i class="bi bi-camera-video"></i></div>
                <div class="stat-title">Webinars Totales</div>
                <div class="stat-value">{{ $totalWebinars }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon text-info"><i class="bi bi-broadcast"></i></div>
                <div class="stat-title">Webinars Activos</div>
                <div class="stat-value">{{ $activeWebinars }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon text-warning"><i class="bi bi-stopwatch"></i></div>
                <div class="stat-title">Webinars Finalizados</div>
                <div class="stat-value">{{ $inactiveWebinars ?? 0 }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon text-success"><i class="bi bi-people"></i></div>
                <div class="stat-title">Usuarios Registrados</div>
                <div class="stat-value">{{ $totalUsers }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon text-purple"><i class="bi bi-check-circle"></i></div>
                <div class="stat-title">Total Inscripciones</div>
                <div class="stat-value">{{ $totalInscripciones }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon text-yellow"><i class="bi bi-graph-up"></i></div>
                <div class="stat-title">Promedio Asistentes / Webinar</div>
                <div class="stat-value">{{ number_format($promedioAsistentes, 1) }}</div>
            </div>
        </div>

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
    </div>

    {{-- TAB 2 - ACTIVIDAD RECIENTE --}}
    <div id="tab2" class="tab-content">
        <div class="recent-activity">
            <h5>🎥 Últimos Webinars</h5>
            @forelse ($ultimosWebinars as $webinar)
                <div class="activity-item">
                    <span><strong>{{ $webinar->titulo }}</strong></span>
                    <span>{{ $webinar->fecha ? \Carbon\Carbon::parse($webinar->fecha)->diffForHumans() : 'Sin fecha' }}</span>
                </div>
            @empty
                <p class="text-muted">No hay webinars recientes.</p>
            @endforelse

            <h5 class="mt-4">👤 Nuevos Usuarios</h5>
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
</div>

<script>
    // Tabs
    const buttons = document.querySelectorAll('.tab-btn');
    const contents = document.querySelectorAll('.tab-content');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            buttons.forEach(b => b.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById(btn.dataset.tab).classList.add('active');
        });
    });

    // Chart.js
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
        options: { responsive: true, scales: { y: { beginAtZero: true } }, plugins: { legend: { display: false } } }
    });

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
        options: { plugins: { legend: { position: 'bottom' }, tooltip: { enabled: true } } }
    });
</script>
@endsection
