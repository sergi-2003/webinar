@extends('layouts.app')

@section('title', 'Mi perfil')

@section('content')
    <h1>👤 Mi perfil</h1>

    <form action="{{ route('profile.update') }}" method="POST" 
          style="max-width:600px; background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); margin-top:20px;">
        @csrf
        @method('PUT')

        <!-- Nombre -->
        <div style="margin-bottom:15px;">
            <label style="font-weight:bold;">Nombre completo:</label><br>
            <input type="text" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" 
                   style="width:100%; padding:10px; border:1px solid #ddd; border-radius:4px;">
        </div>

        <!-- Correo -->
        <div style="margin-bottom:15px;">
            <label style="font-weight:bold;">Correo electrónico:</label><br>
            <input type="email" name="email" value="{{ old('email', $usuario->email) }}" 
                   style="width:100%; padding:10px; border:1px solid #ddd; border-radius:4px;">
        </div>

        <!-- Contraseña -->
        <div style="margin-bottom:15px;">
            <label style="font-weight:bold;">Nueva contraseña:</label><br>
            <input type="password" name="password" placeholder="Dejar en blanco si no deseas cambiarla"
                   style="width:100%; padding:10px; border:1px solid #ddd; border-radius:4px;">
        </div>

        <!-- Rol (solo lectura) -->
        <div style="margin-bottom:15px;">
            <label style="font-weight:bold;">Rol:</label><br>
            <input type="text" value="{{ $usuario->role }}" disabled
                   style="width:100%; padding:10px; border:1px solid #ddd; border-radius:4px; background:#f3f4f6;">
        </div>

        <!-- Fecha registro (solo lectura) -->
        <div style="margin-bottom:15px;">
            <label style="font-weight:bold;">Fecha de registro:</label><br>
            <input type="text" value="{{ $usuario->fecha_registro }}" disabled
                   style="width:100%; padding:10px; border:1px solid #ddd; border-radius:4px; background:#f3f4f6;">
        </div>

        <!-- Botón -->
        <button type="submit" 
                style="background:#0ea5a3; color:#fff; padding:12px 18px; border:none; border-radius:5px; cursor:pointer;">
            Guardar cambios
        </button>
    </form>
@endsection
