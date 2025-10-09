<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal Institucional - Webinars Gubernamentales</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f5f6f8;
      color: #1f2937;
    }

    /* --- NAVBAR --- */
    .navbar {
      background-color: rgb(238, 237, 237);
      box-shadow: 0 2px 10px rgba(0,0,0,0.08);
      padding: 10px 20px;
    }

    .navbar-brand img {
      height: 70px;
      width: auto;
      transition: transform 0.3s ease;
    }
    .navbar-brand img:hover { transform: scale(1.05); }

    .navbar-nav .nav-link {
      color: #000;
      font-weight: 500;
      margin-right: 10px;
      transition: color 0.3s ease;
    }
    .navbar-nav .nav-link:hover {
      color: #0ea5a3;
    }

    /* --- Buscador --- */
    .search-box {
      position: relative;
      margin-right: 10px;
    }
    .search-box input {
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 6px 34px 6px 10px;
      width: 200px;
      transition: all 0.3s ease;
    }
    .search-box input:focus {
      outline: none;
      border-color: #0ea5a3;
      box-shadow: 0 0 0 2px rgba(14,165,163,0.25);
    }
    .search-box i {
      position: absolute;
      right: 10px;
      top: 8px;
      color: #64748b;
    }

    /* --- Botones Reestilizados --- */
    .btn-custom {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      border: none;
      border-radius: 8px;
      font-weight: 500;
      font-size: 0.95rem;
      padding: 8px 16px;
      transition: all 0.25s ease;
      cursor: pointer;
      text-decoration: none;
    }

    .btn-primary-custom {
      background: rgb(7, 137, 48);
      color: white;
      box-shadow: 0 3px 6px rgba(0, 123, 255, 0.25);
    }
    .btn-primary-custom:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 14px rgba(0, 123, 255, 0.35);
      color: #fff;
    }

    .btn-danger-custom {
      background: linear-gradient(135deg, #ef4444, #dc2626);
      color: white;
      box-shadow: 0 3px 6px rgba(239,68,68,0.25);
    }
    .btn-danger-custom:hover {
      transform: translateY(-2px);
      background: linear-gradient(135deg, #dc2626, #b91c1c);
      box-shadow: 0 6px 14px rgba(239,68,68,0.35);
      color: #fff;
    }

    /* --- Contenedor Principal --- */
    .container-content {
      max-width: 1100px;
      margin: 40px auto;
      padding: 0 20px;
    }

    footer {
      background-color: rgb(7, 137, 48);;
      color: white;
      height:100px;
      padding: 20px 0;
      text-align: center;
    }

    /* --- Responsive --- */
    @media (max-width: 992px) {
      .navbar-brand img { height: 55px; }
      .search-box input { width: 140px; }
    }

    @media (max-width: 768px) {
      .navbar-nav {
        background: #f8f9fa;
        padding: 10px;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
      }
      .search-box {
        width: 100%;
        margin: 10px 0;
      }
      .search-box input {
        width: 100%;
      }
    }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{ asset('build/assets/img/logo-alcaldia.png') }}" alt="Logo Gobierno Digital">
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-lg-center">
          <li class="nav-item"><a class="nav-link active" href="{{ route('dashboard') }}">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('webinars.index') }}">Webinars</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Transparencia</a></li>
          <li class="nav-item"><a class="nav-link" href="/admin/dashboard">Panel Administración</a></li>

          @auth
          <li class="nav-item"><a class="nav-link" href="{{ route('inscripciones.mis') }}">Mis Conferencias</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('profile.edit') }}">Mi Perfil</a></li>

          <li class="nav-item">
            <div class="search-box">
              <input type="text" id="buscadorWebinars" placeholder="Buscar...">
              <i class="bi bi-search"></i>
            </div>
          </li>

          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="btn-custom btn-danger-custom">
                <i class="bi bi-box-arrow-right"></i> Salir
              </button>
            </form>
          </li>
          @else
          <li class="nav-item me-2">
            <a href="{{ route('login') }}" class="btn-custom btn-primary-custom">
              <i class="bi bi-person-circle"></i> Iniciar sesión
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('register') }}" class="btn-custom btn-primary-custom">
              <i class="bi bi-pencil-square"></i> Registrarse
            </a>
          </li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>

  <!-- CONTENIDO -->
  <div class="container-content">
    @yield('content')
  </div>

  <!-- FOOTER -->
  <footer>
    &copy; {{ date('Y') }} Gobierno Digital - Todos los derechos reservados.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Script buscador -->
  <script>
  document.getElementById('buscadorWebinars')?.addEventListener('keyup', function(e) {
      if (e.key === 'Enter') {
          const query = e.target.value.trim();
          if (query) {
              window.location.href = `/buscar?query=${encodeURIComponent(query)}`;
          }
      }
  });
  </script>
</body>
</html>
