@extends('layouts.app')

@section('title', 'Registro - WebinarApp')

@section('content')

<style>
    /* Card */
    .register-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(12px);
        border-radius: 18px;
        padding: 2rem;
        width: 100%;
        max-width: 480px;
        margin: 4rem auto;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        animation: fadeIn 1.2s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-25px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    h2 {
        text-align: center;
        font-size: 1.8rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 1.5rem;
    }

    /* Labels */
    label {
        font-weight: 600;
        color: #374151;
        display: block;
        margin-bottom: 0.5rem;
    }

    /* Inputs */
    input {
        width: 100%;
        padding: 0.8rem;
        border-radius: 12px;
        border: 1px solid #d1d5db;
        transition: all 0.3s ease;
    }
    input:focus {
        border-color: rgb(7, 137, 48);
        outline: none;
        box-shadow: rgb(7, 137, 48);
        transform: scale(1.02);
    }

    /* Botón */
   .btn-primary {
    display: inline-block;
    width: 100%;
    padding: 0.9rem;
    margin-top: 1rem;
    background: rgb(7, 137, 48);
    color: #fff;
    font-weight: 700;
    text-align: center;
    border-radius: 12px;
    transition: all 0.3s ease;
    cursor: pointer;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
}

.btn-primary:hover {
    background: rgb(7, 137, 48);
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.35);
}

.btn-primary:active {
    transform: translateY(0) scale(0.97);
    background: linear-gradient(135deg, #8c8c8c, #4a4a4a);
    box-shadow: rgb(7, 137, 48);
}


    /* Enlace login */
    .link {
        display: inline-block;
        margin-top: 1rem;
        font-size: 0.95rem;
        color: rgb(7, 137, 48);
        text-decoration: none;
        transition: 0.3s;
    }
    .link:hover {
        color: #9333ea;
        text-decoration: underline;
    }

    /* Errores */
    .error {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>

<div class="register-card">
    <h2>Crear cuenta</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nombre -->
        <div class="mb-4">
            <label for="nombre">Nombre Completo</label>
            <input id="nombre" type="text" name="nombre" value="{{ old('nombre') }}" required autofocus autocomplete="nombre" placeholder="Nombre y Apellido">
            @error('nombre')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email">Correo electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
            @error('email')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" required autocomplete="new-password">
            @error('password')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation">Confirmar contraseña</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
            @error('password_confirmation')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botón -->
        <button type="submit" class="btn-primary">Registrarse</button>

        <!-- Enlace login -->
        <div class="text-center">
            <a href="{{ route('login') }}" class="link">¿Ya tienes cuenta? Inicia sesión</a>
        </div>
    </form>
</div>

@endsection
