<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\WebinarController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\GrabacionController;
use App\Http\Controllers\AsistenciaController;
use App\Models\Webinar;
use App\Http\Controllers\Admin\WebinarController as AdminWebinarController;
use App\Http\Controllers\Cliente\WebinarController as ClienteWebinarController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Rutas raíz y públicas
|--------------------------------------------------------------------------
*/

// Ruta raíz / home
Route::get('/', function () {
    return view('welcome'); // resources/views/welcome.blade.php
})->name('home');

// Ruta de prueba
Route::get('/test-laravel', function () {
    return 'OK Laravel routes work';
});

// Rutas públicas de webinars
Route::get('/webinars', [WebinarController::class, 'index'])->name('webinars.index');
Route::get('/webinars/{webinar}', [WebinarController::class, 'show'])->name('webinars.show');

/*
|--------------------------------------------------------------------------
| Rutas de autenticación (Breeze / login & register)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Perfil usuario autenticado
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Dashboard general (todos los usuarios autenticados)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->get('/dashboard', function () {
    return view('dashboard'); // resources/views/dashboard.blade.php
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Rutas de webinars protegidas (usuarios autenticados)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Inscribirse a webinar
    Route::post('/webinars/{webinar}/inscribirse', [InscripcionController::class, 'store'])
        ->name('webinars.inscribirse');

    // Ver mis inscripciones
    Route::get('/mis-inscripciones', [InscripcionController::class, 'index'])
        ->name('inscripciones.mis');
});

/*
|--------------------------------------------------------------------------
| Rutas ADMIN (solo rol=admin)
|--------------------------------------------------------------------------
*/
// Admin

route::middleware(['auth', 'can:acceso-admin'])->group(function () {
    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
});

//Cliente
Route::middleware('auth')->group(function () {
    Route::get('/cliente/dashboard', fn() => view('cliente.dashboard'))->name('cliente.dashboard');
});

// Webinars (solo admin)


Route::middleware(['auth', 'can:acceso-admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/webinars', [WebinarController::class, 'index'])->name('webinars.index');
     Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->name('dashboard');
        Route::get('/webinars/create', [WebinarController::class, 'create'])->name('webinars.create');
        Route::post('/webinars', [WebinarController::class, 'store'])->name('webinars.store');
        Route::get('/webinars/{webinar}/edit', [WebinarController::class, 'edit'])->name('webinars.edit');
        Route::put('/webinars/{webinar}', [WebinarController::class, 'update'])->name('webinars.update');
        Route::delete('/webinars/{webinar}', [WebinarController::class, 'destroy'])->name('webinars.destroy');
      
    });
  // Acceso a webinars
Route::get('/webinars/{id}/acceder', [WebinarController::class, 'acceder'])->name('webinars.acceder');
Route::post('/webinars/{id}/acceder', [WebinarController::class, 'validarAcceso'])->name('webinars.validarAcceso');


Route::middleware(['auth'])
    ->prefix('cliente')
    ->name('cliente.')
    ->group(function () {
        Route::get('/dashboard', function() {
            return view('cliente.dashboard');
        })->name('dashboard');

        Route::get('/webinars', [ClienteWebinarController::class, 'index'])->name('webinars.index');
        Route::get('/webinars/{id}/acceder', [ClienteWebinarController::class, 'acceder'])->name('webinars.acceder');
        Route::post('/webinars/{id}/validar', [ClienteWebinarController::class, 'validar'])->name('webinars.validar');
    });

    
Route::prefix('cliente/webinars')->name('cliente.webinars.')->middleware(['auth'])->group(function() {
    Route::get('/', [ClienteWebinarController::class, 'index'])->name('index');
    Route::get('/{id}/acceder', [ClienteWebinarController::class, 'acceder'])->name('acceder');
    Route::post('/{id}/validar', [ClienteWebinarController::class, 'validar'])->name('validar');
});