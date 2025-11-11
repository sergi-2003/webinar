@extends('layouts.app')

@section('title', 'Panel del Cliente')

@section('content')
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body {
        background: #ffffff;
        font-family: 'Poppins', sans-serif;
        overflow-x: hidden;
    }

    /* ====== SLIDER ====== */
    .carousel-container {
        position: relative;
        width: 100%;
        overflow: hidden;
        z-index: 1;
        border-radius:20px
    }

    .carousel-item img {
        width: 100%;
        height: 500px;
        object-fit: ;
        
    }

    .carousel-caption {
        background: rgba(0, 0, 0, 0.55);
        padding: 25px 35px;
        border-radius: 10px;
        backdrop-filter: blur(6px);
    }

    .carousel-caption h2 {
        color: #fff;
        font-size: 2.3rem;
        font-weight: 700;
        text-shadow: 0 3px 8px rgba(0, 0, 0, 0.4);
    }

    .carousel-caption p {
        color: #f1f5f9;
        font-size: 1.1rem;
        margin-top: 10px;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        filter: invert(1);
        width: 2rem;
        height: 2rem;
    }

    /* ====== PASOS ====== */
    .steps {
        text-align: center;
        padding: 100px 20px;
        background: #ffffff;
    }

    .steps h2 {
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 15px;
    }

    .steps p.lead {
        color: #475569;
        margin-bottom: 50px;
    }

    .steps-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 25px;
    }

    .step {
        background: #f9fafb;
        border-radius: 14px;
        padding: 35px 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.06);
    }

    .step i {
        font-size: 2.2rem;
        color: #0ea5a3;
        margin-bottom: 12px;
    }

    .step h4 {
        color: #0f172a;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .step p {
        color: #475569;
        font-size: 0.95rem;
    }
</style>

<!-- ====== SLIDER ====== -->
<div class="carousel-container" data-aos="fade-down">
    <div id="mainCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('build/assets/slider-cliente/logo-alcaldia.png') }}" alt="Transformación Digital">
               <!-- <div class="carousel-caption">
                    <h2>Transforma tu conocimiento en acción</h2>
                    <p>Participa en nuestros webinars exclusivos y lleva tu aprendizaje al siguiente nivel.</p>
                </div>-->
            </div>
            <div class="carousel-item">
                <img src="{{ asset('build/assets/slider-cliente/indera.jpg') }}" alt="Participación Ciudadana">
               <!-- <div class="carousel-caption">
                    <h2>Conéctate con expertos</h2>
                    <p>Aprende de líderes y profesionales que inspiran cambio e innovación.</p>
                </div>-->
            </div>
            <div class="carousel-item">
                <img src="{{ asset('build/assets/slider-cliente/matriculas.jpg') }}" alt="Eventos Virtuales">
                <!--<div class="carousel-caption">
                    <h2>Eventos virtuales a tu alcance</h2>
                    <p>Disfruta de contenido educativo, dinámico y accesible desde cualquier lugar.</p>
                </div>-->
            </div>

            <div class="carousel-item">
                <img src="{{ asset('build/assets/slider-cliente/fiestas.png') }}" alt="Eventos Virtuales">
                <!--<div class="carousel-caption">
                    <h2>Eventos virtuales a tu alcance</h2>
                    <p>Disfruta de contenido educativo, dinámico y accesible desde cualquier lugar.</p>
                </div>-->
            </div>

            <div class="carousel-item">
                <img src="{{ asset('build/assets/slider-cliente/fiestas-2.png') }}" alt="Eventos Virtuales">
                <!--<div class="carousel-caption">
                    <h2>Eventos virtuales a tu alcance</h2>
                    <p>Disfruta de contenido educativo, dinámico y accesible desde cualquier lugar.</p>
                </div>-->
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

<!-- ====== CÓMO PARTICIPAR ====== -->
<section class="steps" data-aos="fade-up">
    <h2>🧭 Cómo participar en un webinar</h2>
    <p class="lead">Sigue estos pasos y aprovecha al máximo tu experiencia de aprendizaje virtual.</p>

    <div class="steps-grid">
        <div class="step" data-aos="zoom-in" data-aos-delay="0">
            <i class="bi bi-box-arrow-in-right"></i>
            <h4>1. Ingresa a tu cuenta</h4>
            <p>Usa tu correo y contraseña registrados para acceder a la plataforma.</p>
        </div>

        <div class="step" data-aos="zoom-in" data-aos-delay="100">
            <i class="bi bi-calendar-check"></i>
            <h4>2. Elige tu webinar</h4>
            <p>Explora la lista de eventos y selecciona el que más te interese.</p>
        </div>

        <div class="step" data-aos="zoom-in" data-aos-delay="200">
            <i class="bi bi-play-circle"></i>
            <h4>3. Confirma tu asistencia</h4>
            <p>Inscríbete y revisa los detalles del evento antes de unirte.</p>
        </div>

        <div class="step" data-aos="zoom-in" data-aos-delay="300">
            <i class="bi bi-chat-dots"></i>
            <h4>4. Participa activamente</h4>
            <p>Disfruta de la transmisión en vivo, comenta y comparte tus ideas.</p>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 900,
        once: true
    });
</script>
@endsection
