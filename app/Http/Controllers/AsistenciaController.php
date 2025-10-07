<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Webinar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{


    /**
     * Listar asistencia de un webinar (admin).
     */
    public function index(Webinar $webinar)
    {
        $asistencias = Asistencia::where('webinar_id', $webinar->id)
            ->with('usuario')
            ->get();

        return view('admin.asistencia.index', compact('webinar','asistencias'));
    }

    /**
     * Registrar tiempo conectado (puede ser llamada por frontend)
     */
    public function store(Request $request, Webinar $webinar)
    {
        $data = $request->validate([
            'tiempo_conectado' => 'required|integer|min:0',
        ]);

        $usuarioId = Auth::id();

        $registro = Asistencia::updateOrCreate(
            ['usuario_id' => $usuarioId, 'webinar_id' => $webinar->id],
            ['tiempo_conectado' => $data['tiempo_conectado']]
        );

        return response()->json(['ok' => true, 'registro' => $registro]);
    }
}
