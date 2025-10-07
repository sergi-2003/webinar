<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['usuario' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $usuario = auth()->user();

        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:usuarios,email,' . $usuario->id,
            'password' => 'nullable|min:6'
        ]);

        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()->route('profile.edit')->with('success', 'Perfil actualizado correctamente ✅');
    }
}
