@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header text-center bg-success bg-gradient text-white py-4">
                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-shield-lock-fill me-2"></i>Restablecer contraseña
                    </h4>
                </div>

                <div class="card-body p-4" style="background-color:#f9fafb;">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold text-success">Correo electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-success border-success">
                                    <i class="bi bi-envelope-fill"></i>
                                </span>
                                <input id="email" 
                                    type="email" 
                                    class="form-control border-success rounded-end @error('email') is-invalid @enderror" 
                                    name="email" 
                                    value="{{ $email ?? old('email') }}" 
                                    required 
                                    autofocus>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold text-success">Nueva contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-success border-success">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input id="password" 
                                    type="password" 
                                    class="form-control border-success rounded-end @error('password') is-invalid @enderror" 
                                    name="password" 
                                    required>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-semibold text-success">Confirmar contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-success border-success">
                                    <i class="bi bi-shield-lock"></i>
                                </span>
                                <input id="password-confirm" 
                                    type="password" 
                                    class="form-control border-success rounded-end" 
                                    name="password_confirmation" 
                                    required>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success bg-gradient py-2 fw-semibold shadow-sm">
                                <i class="bi bi-arrow-repeat me-1"></i>Restablecer contraseña
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center bg-light py-3">
                    <small class="text-muted">
                        Si no solicitaste este cambio, simplemente ignora este mensaje.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Bootstrap Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

@endsection
