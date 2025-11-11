<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario; // o App\Models\User si tu modelo se llama así

class UsuarioController extends Controller
{
    /**
     * Mostrar la lista de usuarios.
     */
    public function index()
    {
        $usuarios = Usuario::orderBy('id', 'asc')->get();

        return view('admin.usuarios.index', compact('usuarios'));
    }

    /**
     * Activar o inactivar un usuario.
     */
    public function toggleEstado($id)
    {
        $usuario = Usuario::findOrFail($id);

        // Cambiar el estado activo/inactivo
        $usuario->activo = !$usuario->activo;
        $usuario->save();

        // Mensaje flash
        $mensaje = $usuario->activo 
            ? '✅ El usuario ha sido activado correctamente.'
            : '🚫 El usuario ha sido inactivado correctamente.';

        return redirect()->back()->with('success', $mensaje);
    }
}
