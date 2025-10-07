<!-- resources/views/webinars/create.blade.php -->
@extends('layouts.app')

@section('title', 'Crear Webinar')

@section('content')
    <h1>Crear webinar</h1>

    <form method="POST" action="{{ route('webinars.store') }}">
        @csrf

        <div class="card">
            <label for="titulo">Título</label><br>
            <input id="titulo" name="titulo" value="{{ old('titulo') }}" style="width:100%; padding:8px;"><br><br>

            <label for="fecha">Fecha (YYYY-MM-DD HH:MM:SS)</label><br>
            <input id="fecha" name="fecha" value="{{ old('fecha') }}" style="width:100%; padding:8px;"><br><br>

            <label for="descripcion">Descripción</label><br>
            <textarea id="descripcion" name="descripcion" style="width:100%; padding:8px;">{{ old('descripcion') }}</textarea><br>

            <div style="margin-top:10px;">
                <button class="btn" type="submit">Guardar webinar</button>
                <a href="{{ route('webinars.index') }}" class="btn" style="background:#6b7280;">Cancelar</a>
            </div>
        </div>
    </form>
@endsection
