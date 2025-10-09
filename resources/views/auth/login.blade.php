@extends('layouts.app')

@section('title', 'Iniciar Sesión - WebinarApp')

@section('content')

<style>
    /* ======== BASE ======== */
    body {
        font-family: 'Poppins', 'Segoe UI', sans-serif;
        min-height: 100vh;
        margin: 0;
        display: flex;
        flex-direction: column;
        color: #1e293b;
    }

    /* ======== NAVBAR ======== */
    nav.navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(12px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 3rem;
        z-index: 100;
        animation: slideDown 0.5s ease;
    }

    @keyframes slideDown {
        from { transform: translateY(-80px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .nav-brand {
        font-weight: 800;
        font-size: 1.5rem;
        color: #111827;
    }

    .nav-links {
        display: flex;
        gap: 2rem;
    }

    nav.navbar a {
        text-decoration: none;
        color: #334155;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    nav.navbar a:hover {
        color: rgb(7, 137, 48);
        transform: translateY(-2px);
    }

    /* ======== LOGIN WRAPPER ======== */
    .login-wrapper {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
        margin-top: 100px;
    }

    /* ======== CARD ======== */
    .login-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        border-radius: 25px;
        padding: 4rem 3rem;
        width: 100%;
        max-width: 850px; /* 👈 mucho más grande */
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        display: flex;
        gap: 3rem;
        align-items: center;
        animation: fadeIn 0.9s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ======== LADO IZQUIERDO (IMAGEN / DECORACIÓN) ======== */
    .login-image {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-image img {
        width: 100%;
        max-width: 300px;
        animation: float 4s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    /* ======== FORMULARIO ======== */
    .login-form {
        flex: 1.2;
    }

    .login-form h2 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: #1e293b;
        text-align: center;
    }

    label {
        font-weight: 600;
        color: rgb(7, 137, 48);
        display: block;
        margin-bottom: 0.4rem;
    }

    input {
        width: 100%;
        padding: 0.9rem 1rem;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        background: rgba(255, 255, 255, 0.85);
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    input:focus {
        border-color: rgb(7, 137, 48);
        outline: none;
        box-shadow: 0 0 12px rgba(99,102,241,0.3);
        transform: scale(1.02);
    }

    .error {
        color: #dc2626;
        font-size: 0.85rem;
        margin-top: 0.3rem;
    }

    /* ======== BOTÓN ======== */
    .btn-primary {
        color: white;
        font-weight: 600;
        border: none;
        border-radius: 12px;
        padding: 15px;
        width: 100%;
        cursor: pointer;
        margin-top: 1rem;
        transition: all 0.3s ease;
        font-size: 1.1rem;
        background-color:rgb(7, 137, 48);
    }

    .btn-primary:hover {
        background: rgb(7, 137, 48);
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(99,102,241,0.45);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    /* ======== FOOTER ======== */
    footer {
        background:
        backdrop-filter: blur(10px);
        text-align: center;
        padding: 1rem;
        font-size: 0.9rem;
        color: white;
        font-size:20px;
        box-shadow: 0 -3px 12px rgba(0,0,0,0.08);
        margin-top: auto;
    }

    /* ======== RESPONSIVE ======== */
    @media (max-width: 768px) {
        .login-card {
            flex-direction: column;
            text-align: center;
            padding: 2.5rem 2rem;
        }

        .login-image {
            display: none;
        }

        .login-form h2 {
            font-size: 1.6rem;
        }
    }
</style>


<!-- ======== LOGIN CARD ======== -->
<div class="login-wrapper">
    <div class="login-card">
        <div class="login-image">
            <img src="{{ asset('build/assets/img/logo.png') }}" alt="Login Illustration">
        </div>

        <div class="login-form">
            <h2>Bienvenido de nuevo 👋</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label for="email">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                    <x-input-error :messages="$errors->get('email')" class="error" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password">Contraseña</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password">
                    <x-input-error :messages="$errors->get('password')" class="error" />
                </div>

                <!-- Botón -->
                <button type="submit" class="btn-primary">Iniciar sesión</button>
            </form>
        </div>
    </div>
</div>


@endsection
