@extends('layouts.app')

@section('title', 'Iniciar Sesión - WebinarApp')

@section('content')

<style>
    /* Card */
    .login-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(12px);
        border-radius: 15px;
        padding: 2rem;
        width: 100%;
        max-width: 420px;
        margin: 4rem auto;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        animation: fadeIn 1.2s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to   { opacity: 1; transform: translateY(0); }
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
        padding: 0.75rem;
        border-radius: 10px;
        border: 1px solid #d1d5db;
        transition: all 0.3s ease;
    }
    input:focus {
        border-color: #6366f1;
        outline: none;
        box-shadow: 0 0 8px rgba(99, 102, 241, 0.5);
        transform: scale(1.02);
    }

    /* Botón */
    .btn-primary {
        background: linear-gradient(135deg, #9f9f9fc2, #6e6e6ec2);
        color: #fff;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        padding: 12px 24px;
        width: 100%;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        backdrop-filter: blur(4px);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #b0b0b0, #5c5c5c);
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.35);
    }

    .btn-primary:active {
        transform: translateY(0) scale(0.97);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    /* Errores */
    .error {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    h2{
        text-align:center;
    }
</style>

<div class="login-card">
    <h2 class="text-center text-2xl font-bold mb-6 text-gray-800">Iniciar sesión</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf
<br>
        <!-- Email -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Correo electrónico')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="error" />
        </div>
<br>
        <!-- Password -->
        <div class="mb-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="error" />
        </div>

        <!-- Botón -->
         <br>
        
        <button type="submit" class="btn-primary">
            {{ __('Iniciar sesión') }}
        </button>
    </form>
</div>

@endsection
