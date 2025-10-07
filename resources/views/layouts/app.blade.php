<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <title>@yield('title', 'Webinar App')</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: "Segoe UI", Roboto, Arial, sans-serif;
            background: linear-gradient(135deg, #9f9f9fc2);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #1f2937;
        }
        a { text-decoration: none; color: inherit; transition: 0.2s; }
        a:hover { color: #6366f1; }

        /* --- Navbar --- */
        nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-radius: 0 0 18px 18px;
            position: relative;
        }
        nav .logo img {
            width: 120px;
            transition: transform 0.3s ease;
        }
        nav .logo img:hover {
            transform: scale(1.08);
        }

        nav .links {
            display: flex;
            align-items: center;
        }
        nav .links a {
            margin-left: 20px;
            font-weight: 500;
            color: #1e293b;
        }
        nav .links form {
            margin-left: 20px; /* separación del botón */
            display: inline-block;
        }
        nav .links span {
            font-weight: 500;
            color: #475569;
            margin-left: 15px;
        }

        /* --- Botón Hamburguesa --- */
        .menu-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }
        .menu-toggle span {
            height: 3px;
            width: 26px;
            background: #1e293b;
            margin: 4px 0;
            border-radius: 3px;
            transition: 0.3s;
        }

        /* --- Responsive --- */
        @media (max-width: 768px) {
            nav .links {
                display: none;
                flex-direction: column;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(12px);
                border-radius: 12px;
                position: absolute;
                top: 70px;
                right: 20px;
                width: 200px;
                box-shadow: 0 6px 20px rgba(0,0,0,0.15);
                padding: 15px;
                gap: 15px; /* separación entre enlaces */
            }

            nav .links.show {
                display: flex;
            }

            .menu-toggle {
                display: flex;
            }
        }

        /* --- Buttons --- */
        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.95rem;
            cursor: pointer;
            border: none;
            font-weight: 500;
            transition: all 0.25s ease-in-out;
        }
        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #38bdf8);
            color: #fff;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99,102,241,0.4);
        }
        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: #fff;
        }
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239,68,68,0.4);
        }

        .container {
            flex: 1;
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
            width: 100%;
            animation: fadeIn 0.6s ease-in-out;
        }
        .card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        }
        .alert-success { border-left: 6px solid #10b981; }
        .alert-error { border-left: 6px solid #ef4444; }
        footer {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 14px 14px 0 0;
            text-align: center;
            padding: 20px;
            font-size: 0.9rem;
            color: #475569;
            box-shadow: 0 -2px 12px rgba(0,0,0,0.08);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000, // duración animación (ms)
        once: true      // se anima solo la primera vez
    });
</script>

    <!-- NAVBAR -->
    <nav>
        <div class="logo">
            <img src="{{ asset('build/assets/img/logo.png') }}" alt="Logo WebinarApp">
        </div>

        <div class="menu-toggle" onclick="document.querySelector('nav .links').classList.toggle('show')">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <div class="links">
            <a href="{{ url('/') }}">Inicio</a>
            @auth
                <a href="{{ route('profile.edit') }}">Mi perfil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Cerrar sesión</button>
                </form>
            @else
             
                <a href="{{ route('register') }}" class="btn btn-primary">Registrarse</a>
            @endauth
        </div>
    </nav>

    <!-- CONTENIDO -->
    <div class="container">
        @if(session('success'))
            <div class="card alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="card alert-error">
                <strong>Errores:</strong>
                <ul style="margin-top:6px; padding-left:20px;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- FOOTER -->
    <footer>
        &copy; {{ date('Y') }} WebinarApp. 🚀 Todos los derechos reservados.
    </footer>
</body>
</html>
