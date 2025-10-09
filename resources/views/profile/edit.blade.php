@extends('layouts.app')

@section('title', 'Mi perfil')

@section('content')

<style>
    body {
        background: #f3f4f6;
        font-family: 'Segoe UI', Roboto, sans-serif;
    }

    .perfil-container {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 60px 20px;
        min-height: 100vh;
    }

    .perfil-card {
        background: #fff;
        width: 100%;
        max-width: 600px;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        padding: 40px 35px;
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .perfil-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .perfil-header h1 {
        color: #0f172a;
        font-size: 1.8rem;
        margin-bottom: 8px;
    }

    .perfil-header p {
        color: #64748b;
        font-size: 0.95rem;
    }

    label {
        font-weight: 600;
        color: #334155;
        display: block;
        margin-bottom: 6px;
    }

    input {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        border: 1px solid #d1d5db;
        background: #f9fafb;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    input:focus {
        background: #fff;
        border-color: #0ea5a3;
        box-shadow: 0 0 6px rgba(14, 165, 163, 0.4);
        outline: none;
    }

    input[disabled] {
        background: #f1f5f9;
        color: #6b7280;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .btn-guardar {
        background: linear-gradient(135deg, #0ea5a3, #14b8a6);
        color: #fff;
        padding: 12px 18px;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        width: 100%;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(14,165,163,0.3);
    }

    .btn-guardar:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(14,165,163,0.4);
    }

    .btn-guardar:active {
        transform: translateY(0);
        box-shadow: 0 2px 8px rgba(14,165,163,0.3);
    }

</style>

<div class="perfil-container">
    <div class="perfil-card">

        <div class="perfil-header">
            <h1>👤 Mi perfil</h1>
            <p>Actualiza tu información personal o cambia tu contraseña</p>
        </div>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div class="form-group">
                <label>Nombre completo:</label>
                <input type="text" name="nombre" value="{{ old('nombre', $usuario->nombre) }}">
            </div>

            <!-- Correo -->
            <div class="form-group">
                <label>Correo electrónico:</label>
                <input type="email" name="email" value="{{ old('email', $usuario->email) }}">
            </div>

            <!-- Contraseña -->
            <div class="form-group">
                <label>Nueva contraseña:</label>
                <input type="password" name="password" placeholder="Dejar en blanco si no deseas cambiarla">
            </div>

            <!-- Rol -->
            <div class="form-group">
                <label>Rol:</label>
                <input type="text" value="{{ $usuario->role }}" disabled>
            </div>

            <!-- Fecha de registro -->
            <div class="form-group">
                <label>Fecha de registro:</label>
                <input type="text" value="{{ $usuario->fecha_registro }}" disabled>
            </div>

            <!-- Botón -->
            <button type="submit" class="btn-guardar">
                Guardar cambios
            </button>
        </form>
    </div>
</div>
@endsection
