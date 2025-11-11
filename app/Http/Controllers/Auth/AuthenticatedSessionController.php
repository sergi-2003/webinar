<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate(); // intenta autenticación

    $user = Auth::user();

    // 🚫 Si está inactivo, se cierra sesión inmediatamente
    if ((int) $user->activo === 0) {
        Auth::logout();

        return back()->withErrors([
            'email' => 'Tu cuenta se encuentra inactiva. Contacta al administrador para mayor información.',
        ]);
    }

    // ✅ Si todo está bien, continúa con la sesión
    $request->session()->regenerate();

    // Redirige según rol
    if ($user->role === 'admin') {
        return redirect('/admin/dashboard');
    }

    return redirect('/dashboard');
}


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
