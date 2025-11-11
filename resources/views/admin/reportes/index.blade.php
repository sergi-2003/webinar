@extends('layouts.admin')

@section('title', 'Reportes del Sistema')

@section('content')
<div class="container py-5">

    <div class="text-center mb-4">
        <h1 class="fw-bold text-success">📊 Módulo de Reportes</h1>
        <p class="text-muted">Descarga la información en formato Excel para análisis y control.</p>
    </div>

    <div class="row g-4">
        <!-- Reporte de Participantes -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h5 class="fw-semibold mb-3">👥 Usuarios Registrados</h5>
                    <p class="text-muted">Exporta todos los participantes de los webinars.</p>
                    <a href="{{ route('admin.reportes.participantes') }}" class="btn btn-success">
                        📤 Descargar Excel
                    </a>
                </div>
            </div>
        </div>

        <!-- Reporte de Inscripciones -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h5 class="fw-semibold mb-3">🗂️ Registro de Inscripciones</h5>
                    <p class="text-muted">Exporta los registros de inscripción a webinars.</p>
                    <a href="{{ route('admin.reportes.inscripciones') }}" class="btn btn-success">
                        📤 Descargar Excel
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
