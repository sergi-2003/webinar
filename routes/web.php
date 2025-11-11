<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\WebinarController as AdminWebinarController;
use App\Http\Controllers\Cliente\WebinarController as ClienteWebinarController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\GrabacionController;
use App\Http\Controllers\AsistenciaController;
use App\Exports\InscripcionesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Admin\ReporteController;
use App\Http\Controllers\Admin\UsuarioController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/test-laravel', fn() => 'OK Laravel routes work');

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

// Enviar el email con token
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

// Formulario para establecer nueva contraseña
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

// Guardar la nueva contraseña
Route::post('password/reset', [ResetPasswordController::class, 'reset'])
    ->name('password.update');
/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| PERFIL DE USUARIO
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD GENERAL
|--------------------------------------------------------------------------
*/
    Route::middleware('auth')->get('/dashboard', fn() => view('dashboard'))->name('dashboard');

/*
|--------------------------------------------------------------------------
| WEBINARS PÚBLICOS (VISITANTES / CLIENTES)
|--------------------------------------------------------------------------
*/
    Route::get('/webinars', [ClienteWebinarController::class, 'index'])->name('webinars.index'); 
    Route::get('/webinars/{webinar}', [ClienteWebinarController::class, 'show'])->name('webinars.show');

/*
|--------------------------------------------------------------------------
| INSCRIPCIONES (USUARIOS AUTENTICADOS) - RUTA GLOBAL PARA MIS CONFERENCIAS
|--------------------------------------------------------------------------
*/
    Route::middleware('auth')->group(function () {
    Route::post('/webinars/{webinar}/inscribirse', [InscripcionController::class, 'store'])->name('webinars.inscribirse');
    
    // Si usas este nombre de ruta, enlace debe ser route('inscripciones.mis')
    Route::get('/mis-inscripciones', [InscripcionController::class, 'index'])->name('inscripciones.mis');
    
    Route::delete('/inscripcion/{id}', [InscripcionController::class, 'destroy'])->name('inscripcion.cancelar');
});

/*
|--------------------------------------------------------------------------
| ADMINISTRADOR
|--------------------------------------------------------------------------
*/
Route::middleware(['auth',  'can:acceso-admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // CRUD de webinars
        Route::get('/webinars', [AdminWebinarController::class, 'index'])->name('webinars.index');
        Route::get('/webinars/create', [AdminWebinarController::class, 'create'])->name('webinars.create');
        Route::post('/webinars', [AdminWebinarController::class, 'store'])->name('webinars.store');
        Route::get('/webinars/{webinar}/edit', [AdminWebinarController::class, 'edit'])->name('webinars.edit');
        Route::put('/webinars/{webinar}', [AdminWebinarController::class, 'update'])->name('webinars.update');
        Route::delete('/webinars/{webinar}', [AdminWebinarController::class, 'destroy'])->name('webinars.destroy');


        Route::get('/webinars/{id}/acceder', [AdminWebinarController::class, 'acceder'])->name('webinars.acceder');

        // Ver inscritos
        Route::get('/webinars/{id}/inscritos', [AdminWebinarController::class, 'verInscritos'])->name('webinars.inscritos');

        // Mis conferencias (CORREGIDO: Ahora usa un nombre específico para admin)
        Route::get('/webinars/mis', [AdminWebinarController::class, 'misConferencias'])->name('webinars.mis-admin');

        // ✅ Activar / Inactivar Webinar
        Route::patch('/webinars/{id}/toggle', [AdminWebinarController::class, 'toggleActivo'])->name('webinars.toggle');

        Route::get('/grabaciones', [GrabacionController::class, 'adminIndex'])->name('grabaciones.index');

        // Crear nueva grabación
        Route::get('/grabaciones/create', [GrabacionController::class, 'create'])->name('grabaciones.create');

        // Guardar grabación
        Route::post('/grabaciones', [GrabacionController::class, 'store'])->name('grabaciones.store');

        // Eliminar grabación
        Route::delete('/grabaciones/{grabacion}', [GrabacionController::class, 'destroy'])->name('grabaciones.destroy');

        // Editar grabación
        Route::get('/grabaciones/{grabacion}/edit', [GrabacionController::class, 'edit'])->name('grabaciones.edit');

        // Actualizar grabación
        Route::put('/grabaciones/{grabacion}', [GrabacionController::class, 'update'])->name('grabaciones.update');

    
// ====== Reportes ======
Route::prefix('reportes')->group(function () {
    Route::get('/', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/exportar/participantes', [ReporteController::class, 'exportParticipantes'])->name('reportes.participantes');
    Route::get('/exportar/inscripciones', [ReporteController::class, 'exportInscripciones'])->name('reportes.inscripciones');
});

    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::post('/usuarios/{id}/toggle', [UsuarioController::class, 'toggleEstado'])->name('usuarios.toggle');
});

/*
|--------------------------------------------------------------------------
| CLIENTE (USUARIOS REGISTRADOS)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')
    ->prefix('cliente')
    ->name('cliente.')
    ->group(function () {
        // Dashboard cliente
        Route::get('/dashboard', fn() => view('cliente.dashboard'))->name('dashboard');

        // Webinars disponibles
        Route::get('/webinars', [ClienteWebinarController::class, 'index'])->name('webinars.index');

        // Acceso y validación del webinar
        Route::get('/webinars/{id}/acceder', [ClienteWebinarController::class, 'acceder'])->name('webinars.acceder');
        
        Route::post('/webinars/{id}/acceder', [ClienteWebinarController::class, 'validarAcceso'])->name('webinars.validar');

        // Mis conferencias
        Route::get('/webinars/mis', [ClienteWebinarController::class, 'misConferencias'])->name('webinars.mis');

        // Inscripción
        Route::post('/webinars/{id}/inscribir', [ClienteWebinarController::class, 'inscribir'])->name('webinars.inscribir');

        // Verificar estado
        Route::get('/webinars/{id}/verificar-estado', [ClienteWebinarController::class, 'verificarEstado'])
        ->name('webinars.verificarEstado');

            
        // ✅ Registrar participante desde modal
        Route::post('/webinars/{id}/registrar-participante', [ClienteWebinarController::class,'registrarParticipante'])->name('webinars.registrar-participante');
    
        // Cancelar inscripción
        Route::delete('/inscripcion/{id}/cancelar', [ClienteWebinarController::class, 'cancelarInscripcion'])
        ->name('inscripcion.cancelar');

        // Ruta del mural de grabaciones
        Route::get('/grabaciones', [GrabacionController::class, 'index'])->name('grabaciones.index');

        Route::get('/webinars/{id}/password', [ClienteWebinarController::class, 'password'])->name('webinars.password');
        });