<?php
namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Webinar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InscripcionController extends Controller
{

    public function index() {
    $inscripciones = Inscripcion::with('webinar')
        ->where('usuario_id', auth()->id())
        ->get();
    return view('cliente.mis-conferencias', compact('inscripciones'));
}


    // Inscribir usuario al webinar
    public function store($webinarId)
    {
        $usuarioId = Auth::id();

        if (Inscripcion::where('usuario_id', $usuarioId)->where('webinar_id', $webinarId)->exists()) {
            return back()->with('warning', '⚠️ Ya estás inscrito en este webinar.');
        }

        Inscripcion::create([
            'usuario_id' => $usuarioId,
            'webinar_id' => $webinarId,
            'fecha_inscripcion' => now(),
        ]);

        return back()->with('success', '✅ Te has inscrito correctamente.');
    }

    // Ver mis inscripciones
    public function misConferencias()
    {
        $inscripciones = Inscripcion::where('usuario_id', Auth::id())
            ->with('webinar')
            ->orderBy('fecha_inscripcion', 'desc')
            ->get();

        return view('cliente.webinars.mis_conferencias', compact('inscripciones'));
    }

    // Cancelar inscripción
    public function destroy($id) {
    $inscripcion = Inscripcion::findOrFail($id);
    if ($inscripcion->usuario_id === auth()->id()) {
        $inscripcion->delete();
        return back()->with('success', 'Inscripción cancelada correctamente.');
    }
    abort(403);
}

}
