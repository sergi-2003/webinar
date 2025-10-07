<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Webinar App</title>
    <style>
        /* Reset */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f172a, #0ea5a3);
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            font-size: 1.5rem;
            letter-spacing: 1px;
        }

        nav a {
            margin-left: 15px;
            text-decoration: none;
            color: #fff;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #38bdf8;
        }

        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 40px 20px;
        }

        main h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        main p {
            font-size: 1.1rem;
            max-width: 600px;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            background: #38bdf8;
            color: #0f172a;
            font-weight: bold;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s, transform 0.2s;
        }

        .btn:hover {
            background: #0ea5a3;
            transform: translateY(-2px);
        }

        footer {
            text-align: center;
            padding: 15px;
            background: rgba(0, 0, 0, 0.2);
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            main h2 {
                font-size: 2rem;
            }
            header {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>🌐 Webinar App</h1>
        <nav>
            @auth
                <a href="{{ url('/dashboard') }}">Dashboard</a>
                <a href="{{ route('profile.edit') }}">Mi perfil</a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none; border:none; color:#fff; cursor:pointer;">Salir</button>
                </form>
            @else
                <a href="{{ route('login') }}">Iniciar sesión</a>
                <a href="{{ route('register') }}">Registrarse</a>
            @endauth
        </nav>
    </header>

    <main>
        <h2>Bienvenido a Webinar App 🎥</h2>
        <p>
            Una plataforma sencilla y poderosa para gestionar tus eventos en línea.  
            Regístrate, administra tus sesiones y conecta con tu comunidad de manera eficiente.
        </p>
        @guest
            <a href="{{ route('register') }}" class="btn">Comenzar ahora</a>
        @endguest
    </main>

    <footer>
        &copy; {{ date('Y') }} Webinar App - Todos los derechos reservados
    </footer>
</body>
</html>
