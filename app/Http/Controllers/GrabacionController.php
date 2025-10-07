<?php

namespace App\Http\Controllers;

use App\Models\Grabacion;
use App\Models\Webinar;
use Illuminate\Http\Request;

class GrabacionController extends Controller
{

    /**
     * Listar grabaciones de un webinar (admin view).
     */
    public function index(Webinar $webinar)
    {
        $grabaciones = Grabacion::where('webinar_id', $webinar->id)->orderByDesc('fecha_subida')->get();
        return view('admin.grabaciones.index', compact('webinar','grabaciones'));
    }

    /**
     * Subir una grabación (admin).
     */
    public function store(Request $request, Webinar $webinar)
    {
        $data = $request->validate([
            'titulo' => 'nullable|string|max:200',
            'video_url' => 'required|url',
        ]);

        $grabacion = Grabacion::create([
            'webinar_id' => $webinar->id,
            'titulo' => $data['titulo'] ?? null,
            'video_url' => $data['video_url'],
        ]);

        return redirect()->route('admin.webinars.grabaciones.index', $webinar->id)
            ->with('success', 'Grabación añadida.');
    }
}
