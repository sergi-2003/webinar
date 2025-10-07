@extends('layouts.app')

@section('title', 'Panel del Cliente')

@section('content')
<style>
    .welcome-section {
        text-align: center;
        margin-bottom: 50px;
    }

    .welcome-section h1 {
        font-size: 2.2rem;
        font-weight: bold;
        color: #0f172a;
    }

    .welcome-section p {
        font-size: 1.1rem;
        color: #475569;
        max-width: 700px;
        margin: 10px auto 0;
    }

    .info-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        margin-bottom: 60px;
        gap: 30px;
    }

    .info-section:nth-child(even) {
        flex-direction: row-reverse;
    }

    .info-text {
        flex: 1;
        min-width: 300px;
        padding: 20px;
    }

    .info-text h2 {
        color: #0ea5a3;
        font-size: 1.8rem;
        margin-bottom: 15px;
    }

    .info-text p {
        color: #475569;
        font-size: 1rem;
        line-height: 1.6;
    }

    .info-img {
        flex: 1;
        min-width: 300px;
    }

    .info-img img {
        width: 100%;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .feature-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 40px;
    }

    .feature-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 18px rgba(0,0,0,0.15);
    }

    .feature-card img {
        width: 80px;
        margin-bottom: 15px;
    }

    .btn-custom {
        background: #0ea5a3;
        color: white;
        border: none;
        padding: 8px 14px;
        border-radius: 6px;
        text-decoration: none;
        transition: background 0.3s ease;
    }

    .btn-custom:hover {
        background: #0c8b88;
    }
</style>

<div class="welcome-section" data-aos="fade-up">
    <h1>👋 Bienvenido, {{ auth()->user()->nombre }}</h1>
    <p>Esta plataforma te permite participar en conferencias, acceder a material grabado y gestionar tu perfil fácilmente.</p>
</div>

<!-- Sección 1 -->
<div class="info-section" data-aos="fade-right">
    <div class="info-img">
        <img src="{{ asset('build/assets/img/conferencia.png') }}" alt="Conferencias en vivo">
    </div>
    <div class="info-text">
        <h2>Participa en conferencias en vivo</h2>
        <p>Conéctate con expertos de diferentes áreas y aprende en sesiones interactivas en tiempo real. 
           Amplía tus conocimientos y forma parte de una comunidad activa.</p>
    </div>
</div>

<!-- Sección 2 -->
<div class="info-section" data-aos="fade-left">
    <div class="info-img">
        <img src="{{ asset('build/assets/img/video-conferecia.png') }}" alt="Accede a grabaciones">
    </div>
    <div class="info-text">
        <h2>Accede a grabaciones pasadas</h2>
        <p>No te pierdas ninguna conferencia. Consulta las grabaciones de eventos anteriores y repasa los temas a tu ritmo desde cualquier dispositivo.</p>
    </div>
</div>

<!-- Sección 3 -->
<div class="info-section" data-aos="fade-right">
    <div class="info-img">
        <img src="{{ asset('build/assets/img/perfil.png') }}" alt="Gestión de perfil">
    </div>
    <div class="info-text">
        <h2>Gestiona tu perfil fácilmente</h2>
        <p>Actualiza tu información personal, revisa tus estadísticas y controla tu progreso de manera intuitiva y segura.</p>
    </div>
</div>

<!-- Tarjetas de acceso rápido -->
<div class="feature-grid" data-aos="zoom-in">
    <div class="feature-card">
        <img src="{{ asset('build/assets/img/profile.png') }}" alt="Perfil">
        <h4>Mi Perfil</h4>
        <p>Consulta y actualiza tu información personal.</p>
        <a href="{{ route('profile.edit') }}" class="btn-custom mt-2">Ir al perfil</a>
    </div>

    <div class="feature-card">
        <img src="{{ asset('build/assets/img/webinars.png') }}" alt="Webinars">
        <h4>Mis Conferencias</h4>
        <p>Accede a tus conferencias activas y revisa tus inscripciones.</p>
        <a href="{{ route('inscripciones.mis') }}" class="btn-custom mt-2">Ver inscripciones</a>
    </div>

    <div class="feature-card">
        <img src="{{ asset('build/assets/img/stats.png') }}" alt="Estadísticas">
        <h4>Estadísticas</h4>
        <p>Visualiza tu progreso y revisa tu historial de participación.</p>
        <a href="#" class="btn-custom mt-2">Ver estadísticas</a>
    </div>
</div>
@endsection
