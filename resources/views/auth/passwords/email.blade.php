@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset_Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        {{-- ✅ SOLO SE MODIFICÓ ESTE BLOQUE --}}
                        <div class="row mb-4 justify-content-center">
                            <div class="col-md-8">
                                <label for="email" class="form-label fw-semibold text-success">
                                    {{ __('Correo electrónico') }}
                                </label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-success text-white border-0">
                                        <i class="bi bi-envelope-fill"></i>
                                    </span>
                                    <input id="email" 
                                           type="email" 
                                           class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           required 
                                           autocomplete="email" 
                                           autofocus
                                           placeholder="ejemplo@correo.com">

                                    @error('email')
                                        <span class="invalid-feedback d-block mt-1">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- ✅ FIN DEL BLOQUE EDITADO --}}

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="bi bi-send me-1"></i> {{ __('Enviar enlace de restablecimiento') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ✅ ESTILOS BREVES --}}
<style>
    .form-control:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 0.25rem rgba(16,185,129,0.25);
    }
    .btn-success {
        background-color: #10b981;
        border:none;
        
    }
    .btn-success:hover {
        background-color: #059669;
    }
</style>
@endsection
