@extends('layouts.app')

@section('title', 'Panel del Cliente')

@section('content')
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body {
        background: #f8fafc;
        font-family: 'Poppins', sans-serif;
        overflow-x: hidden;
    }

    /* ====== SLIDER ====== */
    .carousel-container {
        position: relative;
        width: 100vw;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        overflow: hidden;
        z-index: 1;
        height:800px;
    }

    #mainCarousel {
        width: 100%;
    }

    .carousel-item img {
        width: 100%;
        height: 800px;
        object-fit: hidden;
        filter: brightness(0.75);
    }

    .carousel-caption {
        background: rgba(0, 0, 0, 0.55);
        padding: 30px 40px;
        border-radius: 10px;
        backdrop-filter: blur(6px);
    }

    .carousel-caption h2 {
        color: #fff;
        font-size: 2.6rem;
        font-weight: 700;
        text-shadow: 0 3px 8px rgba(0, 0, 0, 0.4);
    }

    .carousel-caption p {
        color: #f1f5f9;
        font-size: 1.2rem;
        margin-top: 10px;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        filter: invert(1);
        width: 2.5rem;
        height: 2.5rem;
    }

    /* ====== BIENVENIDA ====== */
    .welcome-section {
        text-align: center;
        margin: 80px auto 60px;
    }

    .welcome-section h1 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #0f172a;
    }

    .welcome-section p {
        font-size: 1.1rem;
        color: #475569;
        max-width: 700px;
        margin: 15px auto 0;
    }

    /* ====== INFO SECTIONS ====== */
    .info-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        margin-bottom: 80px;
        gap: 40px;
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
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.12);
    }

    /* ====== FEATURES ====== */
    .feature-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-top: 60px;
        margin-bottom: 100px;
    }

    .feature-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .feature-card img {
        width: 90px;
        margin-bottom: 15px;
    }

    .feature-card h4 {
        color: #0f172a;
        font-weight: 600;
    }

    .btn-custom {
        background: #0ea5a3;
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        text-decoration: none;
        transition: background 0.3s ease;
    }

    .btn-custom:hover {
        background: #0c8b88;
    }
</style>

<!-- ====== SLIDER ====== -->
<div class="carousel-container" data-aos="fade-down">
    <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('build/assets/img/trasnformacion-digital.jpg') }}" alt="Conferencias en vivo">
             
            </div>
            <div class="carousel-item">
                <img src="{{ asset('build/assets/img/participacion-ciudadana.jpeg') }}" alt="Acceso a grabaciones">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('build/assets/img/FIESTAS.png') }}" alt="Gestión de perfil">
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>

<!-- ====== BIENVENIDA ====== -->
<div class="welcome-section" data-aos="fade-up">
    <h1>👋 Hola, {{ auth()->user()->nombre }}</h1>
    <p>Explora conferencias en vivo, accede a material grabado y gestiona tu perfil fácilmente desde esta plataforma.</p>
</div>

<!-- ====== SECCIONES DE INFORMACIÓN ====== -->
<div class="container">
    <div class="info-section" data-aos="fade-right">
        <div class="info-img">
            <img src="{{ asset('build/assets/img/conferencia.png') }}" alt="Conferencias en vivo">
        </div>
        <div class="info-text">
            <h2>Participa en conferencias en vivo</h2>
            <p>Conéctate con expertos en tiempo real, realiza preguntas y aprende de experiencias reales.</p>
        </div>
    </div>

    <div class="info-section" data-aos="fade-left">
        <div class="info-img">
            <img src="{{ asset('build/assets/img/video-conferecia.png') }}" alt="Grabaciones">
        </div>
        <div class="info-text">
            <h2>Accede a grabaciones pasadas</h2>
            <p>No te preocupes si te perdiste un evento. Puedes acceder al material cuando quieras desde tu panel.</p>
        </div>
    </div>

        <div class="info-section" data-aos="fade-left">
        <div class="info-img">
            <img src="{{ asset('build/assets/img/webinar.jpg') }}" alt="Grabaciones">
        </div>
        <div class="info-text">
            <h2>Registra tu asistencia</h2>
            <p>No te preocupes .</p>
        </div>
    </div>

    <div class="info-section" data-aos="fade-right">
        <div class="info-img">
            <img src="{{ asset('build/assets/img/avatar.png') }}" alt="Gestión de perfil">
        </div>
        <div class="info-text">
            <h2>Gestiona tu perfil</h2>
            <p>Actualiza tu información, cambia tu contraseña y revisa tus estadísticas personales de participación.</p>
        </div>
    </div>

    <!-- ====== ACCESOS RÁPIDOS ====== 
    <div class="feature-grid" data-aos="zoom-in">
        <div class="feature-card">
            <img src="{{ asset('build/assets/img/avatar.png') }}" alt="Perfil">
            <h4>Mi Perfil</h4>
            <p>Consulta y actualiza tu información personal.</p>
            <a href="{{ route('profile.edit') }}" class="btn-custom mt-2">Ir al perfil</a>
        </div>

        <div class="feature-card">
            <img src="{{ asset('build/assets/img/reunion.png') }}" alt="Webinars">
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
    </div>-->
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 900,
        once: true
    });
</script>
@endsection
