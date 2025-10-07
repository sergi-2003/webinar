@extends('layouts.app')

@section('title', 'Dashboard Cliente')

@section('content')
    <h1 style="margin-bottom:20px;">👋 Bienvenido, {{ auth()->user()->nombre }}</h1>

    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap:20px;">
        <!-- Tarjeta: Perfil -->
        <div style="background:#f9fafb; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
            <h3>👤 Mi perfil</h3>
            <p>Consulta y actualiza tus datos personales.</p>
            <a href="{{ route('profile.edit') }}" 
               style="display:inline-block; margin-top:10px; background:#0ea5a3; color:white; padding:8px 12px; border-radius:5px; text-decoration:none;">
               Ver perfil
            </a>
        </div>

        <!-- Tarjeta: Webinars disponibles -->
        <div style="background:#f9fafb; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
            <h3>🎥 Webinars disponibles</h3>
            <p>Explora los próximos eventos y regístrate fácilmente.</p>
            <a href="{{ route('webinars.index') }}" 
               style="display:inline-block; margin-top:10px; background:#3b82f6; color:white; padding:8px 12px; border-radius:5px; text-decoration:none;">
               Ver webinars
            </a>
        </div>

        <!-- Tarjeta: Mis inscripciones -->
        <div style="background:#f9fafb; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
            <h3>📝 Mis inscripciones</h3>
            <p>Consulta tus webinars inscritos y enlaces de acceso.</p>
            <a href="{{ route('inscripciones.mis') }}" 
               style="display:inline-block; margin-top:10px; background:#16a34a; color:white; padding:8px 12px; border-radius:5px; text-decoration:none;">
               Ver inscripciones
            </a>
        </div>
    </div>
@endsection
