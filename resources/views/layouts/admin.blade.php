<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal Institucional - Webinars Gubernamentales</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Segoe UI', Roboto, sans-serif;
      background-color: #f7f9fb;
      color: #1f2937;
    }

    
    /* --- NAVBAR --- */
    .navbar {
      background: #ffffff;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
      padding: 12px 0;
      transition: all 0.3s ease;
    }

    .navbar-brand img {
      height: 65px;
      transition: transform 0.3s ease;
    }
    .navbar-brand img:hover {
      transform: scale(1.04);
    }

    .navbar-nav .nav-link {
      color: #1f2937;
      font-weight: 500;
      position: relative;
      transition: color 0.3s ease;
      margin: 0 6px;
    }
    .navbar-nav .nav-link:hover {
      color: #0ea5a3;
    }
    .navbar-nav .nav-link.active::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 50%;
      transform: translateX(-50%);
      width: 40%;
      height: 2px;
      background: #0ea5a3;
      border-radius: 2px;
    }

    /* --- Buscador --- */
    .search-box {
      position: relative;
      margin-right: 12px;
    }
    .search-box input {
      border: 1px solid #cbd5e1;
      border-radius: 10px;
      padding: 8px 38px 8px 12px;
      width: 220px;
      font-size: 0.9rem;
      transition: all 0.3s ease;
      background-color: #f8fafc;
    }
    .search-box input:focus {
      border-color: #0ea5a3;
      box-shadow: 0 0 0 3px rgba(14,165,163,0.2);
      outline: none;
      background-color: white;
    }
    .search-box i {
      position: absolute;
      right: 12px;
      top: 9px;
      color: #64748b;
      font-size: 1rem;
    }

    /* --- Botones Custom --- */
    .btn-custom {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      border-radius: 10px;
      font-weight: 600;
      font-size: 0.95rem;
      padding: 8px 18px;
      transition: all 0.25s ease;
      cursor: pointer;
      text-decoration: none;
    }

    .btn-success-custom {
      background: linear-gradient(135deg, #198754, #20c997);
      color: white;
      border: none;
      box-shadow: 0 3px 6px rgba(25, 135, 84, 0.25);
    }
    .btn-success-custom:hover {
      background: linear-gradient(135deg, #157347, #17b09e);
      transform: translateY(-2px);
      box-shadow: 0 6px 14px rgba(25,135,84,0.35);
      color: #fff;
    }

    .btn-danger-custom {
      background: linear-gradient(135deg, #ef4444, #dc2626);
      color: white;
      border: none;
      box-shadow: 0 3px 6px rgba(239,68,68,0.25);
    }
    .btn-danger-custom:hover {
      background: linear-gradient(135deg, #dc2626, #b91c1c);
      transform: translateY(-2px);
      box-shadow: 0 6px 14px rgba(239,68,68,0.35);
    }

    /* --- Footer --- */
    footer {
      background-color: #198754;
      color: white;
      text-align: center;
      padding: 25px 10px;
      margin-top: 100px;
      font-size: 0.95rem;
      letter-spacing: 0.3px;
      height:150px;
    }

    /* --- Responsive --- */
    @media (max-width: 992px) {
      .navbar-brand img { height: 55px; }
      .search-box input { width: 160px; }
    }

    @media (max-width: 768px) {
      .navbar-nav {
        background: #f9fafb;
        padding: 10px;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
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
      <a class="navbar-brand" href="#">
        <img src="{{ asset('build/assets/img/logo-alcaldia.png') }}" alt="Logo Alcaldía de Armenia">
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-lg-center">

          
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.webinars.index') }}">Webinars</a></li>
          <li class="nav-item"><a class="nav-link active" href="{{ route('admin.dashboard') }}">Panel Administrativo</a></li>
          <li class="nav-item"><a class="nav-link" href="/admin/grabaciones">Subir Grabación</a></li>
          <li class="nav-item"><a class="nav-link" href="/admin/usuarios">Panel Usuarios</a></li>

          @auth
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
            <a href="{{ route('login') }}" class="btn-custom btn-success-custom">
              <i class="bi bi-person-circle"></i> Iniciar sesión
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('register') }}" class="btn-custom btn-success-custom">
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
    &copy; {{ date('Y') }} Alcaldía de Armenia - Gobierno Digital. Todos los derechos reservados.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Buscador -->
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
