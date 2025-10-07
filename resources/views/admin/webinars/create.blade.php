@extends('layouts.app')

@section('title', 'Crear Webinar')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">🎥 Crear nuevo webinar</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.webinars.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input type="datetime-local" name="fecha" class="form-control" required>
        </div>

        <div class="mb-3">
    <label for="password" class="form-label">Contraseña (opcional)</label>
    <input type="text" name="password" id="password" class="form-control" placeholder="Dejar vacío si no quiere" value="{{ old('password', $webinar->password ?? '') }}">
</div>


   <select name="estado" class="form-select">
    <option value="proximo">Próximo</option>
    <option value="en_vivo">En vivo</option>
    <option value="finalizado">Finalizado</option>
</select>

        <button type="submit" class="btn btn-success">Crear Webinar</button>
        <a href="{{ route('admin.webinars.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection
