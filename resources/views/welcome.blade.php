<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal Institucional - Webinars Gubernamentales</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* --- ESTILOS GENERALES --- */
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #eeeded80;
      color: #000;
      overflow-x: hidden;
    }

    /* --- NAVBAR --- */
    .navbar {
      background-color: #EEEDED !important;
    }

    .navbar .nav-link {
      color: #078930 !important;
      font-weight: 600;
      transition: color 0.3s ease;
      font-size:20px
    }

    .navbar .nav-link:hover {
      color: #000 !important;
    }

    .logo {
      height: 80px;
      width: auto;
    }

    /* --- SLIDER --- */
    .carousel-item img {
      width: 100%;
      height: 700px;
     
      object-position: center;
    }

    .carousel-caption {
      background: rgba(0, 0, 0, 0.5);
      border-radius: 10px;
    }

    /* --- CUBOS INFORMATIVOS --- */
    .info-cards .card {
      border: none;
      border-radius: 12px;
      transition: all 0.3s ease;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
    }

    .info-cards .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 14px rgba(0, 0, 0, 0.15);
    }

    .info-icon {
      font-size: 50px;
      color: #078930;
    }

    footer {
      background-color: #078930;
      color: white;
      padding: 20px 0;
      margin-top: 50px;
    }

    /* --- TITULO PRINCIPAL --- */
    h1 {
      text-align: center;
      margin-top: 30px;
      color: #078930;
      font-weight: 700;
      
    }

    /* --- RESPONSIVE --- */
    @media (max-width: 992px) {
      .logo {
        height: 60px;
      }
      .carousel-item img {
        height: 450px;
      }
    }

    @media (max-width: 768px) {
      .carousel-item img {
        height: 350px;
      }
      .carousel-caption h3 {
        font-size: 1.2rem;
      }
      .carousel-caption p {
        font-size: 0.9rem;
      }
    }

    @media (max-width: 576px) {
      .carousel-item img {
        height: 250px;
      }
      h1 {
        font-size: 1.5rem;
      }
      .info-cards .card {
        margin-bottom: 20px;
      }
    }
  </style>
</head>

<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="{{ asset('build/assets/img/logo-alcaldia.png') }}" alt="Gobierno Digital" class="logo">
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link active" href="#">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Webinars</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Transparencia</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Contacto</a></li>
          <li class="nav-item"><a class="nav-link" href="/register">Registro</a></li>
          <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- TÍTULO -->
  <h1>GOBIERNO DIGITAL</h1>

  <!-- SLIDER -->
  <div id="mainCarousel" class="carousel slide mt-3" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
      <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
      <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
      <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="3"></button>
    </div>

    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="{{ asset('build/assets/img/trasnformacion-digital.jpg') }}" alt="Gobierno Digital">
        <div class="carousel-caption d-none d-md-block p-3">
          <h3>Transformación Digital del Estado</h3>
          <p>Innovando para servir mejor a la ciudadanía.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="{{ asset('build/assets/img/Informacion-digital.png') }}" alt="Manejo de Información">
        <div class="carousel-caption d-none d-md-block p-3">
          <h3>Manejo de Información Ciudadana</h3>
          <p>Participa en los cursos institucionales gratuitos.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="{{ asset('build/assets/img/Cultura-Ciudadana.jpeg') }}" alt="Cultura Ciudadana">
        <div class="carousel-caption d-none d-md-block p-3">
          <h3>Cultura Ciudadana</h3>
          <p>Ten un manejo adecuado en las vías.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="{{ asset('build/assets/img/participacion-ciudadana.jpeg') }}" alt="Participación Ciudadana">
        <div class="carousel-caption d-none d-md-block p-3">
          <h3>Participación Ciudadana</h3>
          <p>Tu voz es esencial para construir un mejor país.</p>
        </div>
      </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>

  <!-- CUBOS INFORMATIVOS -->
  <div class="container my-5 info-cards">
    <div class="row text-center">
      <div class="col-md-3 col-sm-6 mb-4">
        <div class="card p-4 h-100">
          <div class="info-icon mb-3">🏛️</div>
          <h5 class="card-title fw-bold">Transparencia</h5>
          <p class="card-text">Accede a la información pública y conoce cómo se gestionan los recursos.</p>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 mb-4">
        <div class="card p-4 h-100">
          <div class="info-icon mb-3">💻</div>
          <h5 class="card-title fw-bold">Gobierno Digital</h5>
          <p class="card-text">Digitalizamos los servicios públicos para mayor agilidad y eficiencia.</p>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 mb-4">
        <div class="card p-4 h-100">
          <div class="info-icon mb-3">🎓</div>
          <h5 class="card-title fw-bold">Capacitación</h5>
          <p class="card-text">Participa en webinars y cursos en línea para fortalecer tus conocimientos.</p>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 mb-4">
        <div class="card p-4 h-100">
          <div class="info-icon mb-3">🤝</div>
          <h5 class="card-title fw-bold">Participación</h5>
          <p class="card-text">Involúcrate en los procesos y aporta ideas para mejorar la gestión pública.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <footer class="text-center">
    <div class="container">
      <p class="mb-0">&copy; {{ date('Y') }} Gobierno Digital - Todos los derechos reservados</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
