<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webinars App</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">WebinarsApp</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        @guest
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registro</a></li>
        @else
          <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="btn btn-link nav-link" style="display:inline;padding:0;">Logout</button>
            </form>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <h1 class="mb-4">Bienvenido a Webinars App</h1>
    <p>Descubre y participa en los mejores webinars de nuestra plataforma.</p>

    <a href="{{ route('webinars.index') }}" class="btn btn-primary">Ver Webinars</a>
</div>

<footer class="bg-dark text-white mt-5 p-3 text-center">
    &copy; {{ date('Y') }} Webinars App
</footer>

</body>
</html>
