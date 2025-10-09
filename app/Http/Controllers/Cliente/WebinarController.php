<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Webinar;
use Illuminate\Http\Request;

class WebinarController extends Controller
{
    /** 🏠 Muestra todos los webinars disponibles */
    public function index(Request $request)
    {
        $query = Webinar::query();

        if ($request->filled('q')) {
            $query->where('titulo', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $webinars = $query->orderBy('fecha', 'desc')->get();

        // Si la solicitud viene por AJAX, solo retornamos la lista parcial
        if ($request->ajax()) {
            return view('cliente.webinars.partials.lista', compact('webinars'))->render();
        }

        return view('cliente.webinars.index', compact('webinars'));
    }

    /** 🔒 Formulario de acceso para webinars privados */
    public function acceder($id)
    {
        $webinar = Webinar::findOrFail($id);

        // Si el webinar no tiene contraseña, redirigimos directamente
        if (empty($webinar->password)) {
            return redirect()->away($webinar->video_url);
        }

        return view('cliente.webinars.acceder', compact('webinar'));
    }

    /** ✅ Valida la contraseña e ingresa al webinar */
    public function validar(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string',
        ], [
            'password.required' => 'Por favor ingresa la contraseña del webinar.',
        ]);

        $webinar = Webinar::findOrFail($id);

        if ($webinar->password && $webinar->password === $request->password) {
            return redirect()->away($webinar->video_url);
        }

        return back()->withErrors([
            'password' => '❌ Contraseña incorrecta. Inténtalo de nuevo.'
        ])->withInput();
    }
}
