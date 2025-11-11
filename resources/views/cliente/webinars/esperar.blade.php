@extends('layouts.app')

@section('title', 'Webinar Privado')

@section('content')
<div class="container text-center py-5">
    <i class="bi bi-lock-fill display-1 text-warning mb-3"></i>
    <h3 class="fw-bold">Webinar privado</h3>
    <p>El anfitrión aún no ha iniciado la reunión. Por favor, inténtalo más tarde.</p>
    <a href="{{ route('cliente.webinars.index') }}" class="btn btn-outline-success rounded-pill mt-3">
        <i class="bi bi-arrow-left-circle me-1"></i> Volver a mis webinars
    </a>
</div>
@endsection
