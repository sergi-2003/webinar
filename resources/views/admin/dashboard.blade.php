@extends('layouts.admin')

@section('title', 'Dashboard de Métricas')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<style>
    /* === ESTILOS GENERALES === */
    body {
        background-color: #f8fafc;
    }

    .dashboard-header {
        background: linear-gradient(90deg, #37b24d, #2f9e44);
        color: white;
        border-radius: 1rem;
        padding: 1.5rem 2rem;
        box-shadow: 0 4px 20px rgba(55, 178, 77, 0.3);
    }

    .dashboard-header h2 {
        font-weight: 700;
    }

    /* === TARJETAS === */
    .metric-card {
        border: none;
        border-radius: 1rem;
        background: white;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
    }

    .metric-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .metric-icon {
        font-size: 2rem;
        color: #37b24d;
    }

    .metric-label {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .metric-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2f9e44;
    }

    /* === GRÁFICOS === */
    .chart-card {
        border: none;
        border-radius: 1rem;
        background: white;
        padding: 1rem 1.25rem;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    .chart-card:hover {
        transform: translateY(-4px);
    }

    .chart-container {
        position: relative;
        height: 330px;
        width: 100%;
    }

    /* === TABLA === */
    .table-card {
        border-radius: 1rem;
        background: white;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .table thead {
        background-color: #37b24d;
        color: white;
    }

    .table tbody tr:hover {
        background-color: #f1f3f5;
    }

    .table th, .table td {
        vertical-align: middle;
    }
</style>

<div class="container py-5">
    <div class="dashboard-header mb-5">
        <h2><i class="bi bi-bar-chart"></i> Panel de Métricas Generales</h2>
        <p class="mb-0">Visualiza el comportamiento general de los webinars, inscripciones y participación.</p>
    </div>

    <!-- === TARJETAS === -->
    <div class="row g-4 mb-5 text-center">
        <div class="col-md-3 col-6">
            <div class="metric-card p-3">
                <i class="bi bi-person-circle metric-icon"></i>
                <div class="metric-label mt-2">Usuarios</div>
                <div class="metric-value">{{ $totalUsers }}</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="metric-card p-3">
                <i class="bi bi-journal-check metric-icon"></i>
                <div class="metric-label mt-2">Inscripciones</div>
                <div class="metric-value">{{ $totalInscripciones }}</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="metric-card p-3">
                <i class="bi bi-easel2 metric-icon"></i>
                <div class="metric-label mt-2">Webinars</div>
                <div class="metric-value">{{ $totalWebinars }}</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="metric-card p-3">
                <i class="bi bi-people-fill metric-icon"></i>
                <div class="metric-label mt-2">Promedio Asistentes</div>
                <div class="metric-value">{{ number_format($promedioAsistentes, 1) }}</div>
            </div>
        </div>
    </div>

    <!-- === GRÁFICOS === -->
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="chart-card">
                <h6 class="fw-bold text-success mb-3"><i class="bi bi-gender-ambiguous"></i> Distribución por Sexo</h6>
                <div class="chart-container"><canvas id="chartSexo"></canvas></div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="chart-card">
                <h6 class="fw-bold text-success mb-3"><i class="bi bi-person-lines-fill"></i> Grupo Poblacional</h6>
                <div class="chart-container"><canvas id="chartGrupo"></canvas></div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="chart-card">
                <h6 class="fw-bold text-success mb-3"><i class="bi bi-globe-americas"></i> Distribución por Etnia</h6>
                <div class="chart-container"><canvas id="chartEtnia"></canvas></div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="chart-card">
                <h6 class="fw-bold text-success mb-3"><i class="bi bi-bar-chart-line"></i> Rango de Edad</h6>
                <div class="chart-container"><canvas id="chartEdad"></canvas></div>
            </div>
        </div>

        <div class="col-12">
            <div class="chart-card">
                <h6 class="fw-bold text-success mb-3"><i class="bi bi-calendar-event"></i> Tendencia Mensual de Inscripciones</h6>
                <div class="chart-container"><canvas id="chartTendencia"></canvas></div>
            </div>
        </div>
    </div>

    <!-- === TABLA DE RESUMEN === -->
    <div class="table-card">
        <h5 class="fw-bold text-success mb-3"><i class="bi bi-table"></i> Resumen de Webinars</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Título</th>
                        <th>Inscritos</th>
                        <th>Participantes</th>
                        <th>% Participación</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tablaWebinars as $w)
                    <tr>
                        <td>{{ $w->fecha_formateada }}</td>
                        <td>{{ $w->titulo }}</td>
                        <td>{{ $w->inscripciones_count }}</td>
                        <td>{{ $w->total_participantes }}</td>
                        <td><span class="badge bg-success">{{ $w->porcentaje }}%</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
Chart.register(ChartDataLabels);

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { position: 'bottom' },
        datalabels: {
            color: '#fff',
            font: { weight: 'bold' },
            formatter: (value, ctx) => {
                let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                let percentage = ((value / sum) * 100).toFixed(1) + "%";
                return percentage;
            }
        }
    }
};

// === GRÁFICOS ===
new Chart(document.getElementById('chartSexo'), {
    type: 'doughnut',
    data: {
        labels: @json(array_keys($porSexo->toArray())),
        datasets: [{ data: @json(array_values($porSexo->toArray())), backgroundColor: ['#51cf66', '#339af0', '#fcc419'] }]
    },
    options: chartOptions,
    plugins: [ChartDataLabels]
});

new Chart(document.getElementById('chartGrupo'), {
    type: 'bar',
    data: {
        labels: @json(array_keys($porGrupo->toArray())),
        datasets: [{ label: 'Cantidad', data: @json(array_values($porGrupo->toArray())), backgroundColor: '#37b24d' }]
    },
    options: { ...chartOptions, plugins: { datalabels: false }, scales: { x: { beginAtZero: true } } }
});

new Chart(document.getElementById('chartEtnia'), {
    type: 'bar',
    data: {
        labels: @json(array_keys($porEtnia->toArray())),
        datasets: [{ label: 'Cantidad', data: @json(array_values($porEtnia->toArray())), backgroundColor: '#74c69d' }]
    },
    options: { ...chartOptions, plugins: { datalabels: false } }
});

new Chart(document.getElementById('chartEdad'), {
    type: 'bar',
    data: {
        labels: @json(array_keys($porEdad->toArray())),
        datasets: [{ label: 'Participantes', data: @json(array_values($porEdad->toArray())), backgroundColor: '#69db7c' }]
    },
    options: { ...chartOptions, plugins: { datalabels: false }, scales: { x: { beginAtZero: true }, y: { beginAtZero: true } } }
});

new Chart(document.getElementById('chartTendencia'), {
    type: 'line',
    data: {
        labels: @json($meses),
        datasets: [{
            label: 'Inscripciones',
            data: @json($totalesMes),
            borderColor: '#2b8a3e',
            backgroundColor: 'rgba(55,178,77,0.15)',
            tension: 0.3,
            fill: true,
            pointRadius: 5
        }]
    },
    options: { ...chartOptions, plugins: { datalabels: false } }
});
</script>
@endsection
