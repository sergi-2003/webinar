<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
   $request->validate([
    'nombre' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios'],
    'password' => ['required', 'confirmed', Rules\Password::defaults()],
]);

$usuario = Usuario::create([
    'nombre'   => $request->nombre,
    'email'    => strtolower($request->email), // 👈 aquí lo bajas a minúsculas
    'password' => Hash::make($request->password),
    'rol'      => 'cliente',
]);
        event(new Registered($usuario));

        Auth::login($usuario);

        return redirect(RouteServiceProvider::HOME);
    }
}
