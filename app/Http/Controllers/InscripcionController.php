<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Webinar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InscripcionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store: inscribir usuario autenticado en un webinar (cliente).
     */
    public function store(Webinar $webinar, Request $request)
    {
        $userId = Auth::id();

        // Prevención de duplicados
        $exists = Inscripcion::where('usuario_id', $userId)
            ->where('webinar_id', $webinar->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['Ya estás inscrito en este webinar.']);
        }

        Inscripcion::create([
            'usuario_id' => $userId,
            'webinar_id' => $webinar->id,
        ]);

        return back()->with('success', 'Inscripción completada.');
    }

    /**
     * Listar inscripciones del usuario (cliente).
     */
    public function index()
    {
        $userId = Auth::id();
        $inscripciones = Inscripcion::where('usuario_id', $userId)
            ->with('webinar')
            ->orderByDesc('fecha_inscripcion')
            ->get();

        return view('inscripciones.index', compact('inscripciones'));
    }

    /**
     * Para el admin: listar inscripciones de un webinar.
     */
    public function adminIndex(Webinar $webinar)
    {
        $inscripciones = Inscripcion::where('webinar_id', $webinar->id)
            ->with('usuario') // requiere relación en el modelo Inscripcion
            ->get();

        return view('admin.inscripciones.index', compact('webinar', 'inscripciones'));
    }

    /**
     * Exportar inscripciones a CSV (admin).
     */
    public function export(Webinar $webinar)
    {
        $inscripciones = Inscripcion::where('webinar_id', $webinar->id)
            ->with('usuario')
            ->get();

        $response = new StreamedResponse(function () use ($inscripciones) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['usuario_id', 'nombre', 'email', 'fecha_inscripcion']);

            foreach ($inscripciones as $ins) {
                $usuario = $ins->usuario ?? null;
                fputcsv($handle, [
                    $ins->usuario_id,
                    $usuario ? $usuario->nombre : '',
                    $usuario ? $usuario->email : '',
                    $ins->fecha_inscripcion,
                ]);
            }

            fclose($handle);
        });

        $filename = 'inscripciones_webinar_'.$webinar->id.'.csv';
        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");

        return $response;
    }
}
