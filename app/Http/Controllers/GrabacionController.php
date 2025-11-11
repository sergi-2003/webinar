<?php
namespace App\Http\Controllers;

use App\Models\Grabacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GrabacionController extends Controller
{
    // Mural público (cliente)
    public function index()
    {
        $grabaciones = Grabacion::latest('fecha_publicacion')->get();
        return view('cliente.mural', compact('grabaciones'));
    }

    // Vista para admin
    public function adminIndex()
    {
        $grabaciones = Grabacion::latest()->get();
        return view('admin.grabaciones.index', compact('grabaciones'));
    }

    // Formulario crear
    public function create()
    {
        return view('admin.grabaciones.create');
    }

    // Guardar nueva grabación
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'video_url' => 'required|url',
            'descripcion' => 'nullable|string',
            'miniatura' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('titulo', 'descripcion', 'video_url');
        $data['usuario_id'] = Auth::id();
        $data['fecha_publicacion'] = now();

        // subir miniatura si existe
        if ($request->hasFile('miniatura')) {
            $data['miniatura'] = $request->file('miniatura')->store('grabaciones', 'public');
        }

        Grabacion::create($data);

        return redirect()->route('admin.grabaciones.index')->with('success', 'Grabación publicada correctamente.');
    }

    // Eliminar grabación
    public function destroy(Grabacion $grabacion)
    {
        $grabacion->delete();
        return back()->with('success', 'Grabación eliminada con éxito.');
    }

    // Mostrar formulario de edición
public function edit(Grabacion $grabacion)
{
    return view('admin.grabaciones.edit', compact('grabacion'));
}

// Actualizar grabación
public function update(Request $request, Grabacion $grabacion)
{
    $request->validate([
        'titulo' => 'required|string|max:255',
        'video_url' => 'required|url',
        'descripcion' => 'nullable|string',
        'miniatura' => 'nullable|image|max:2048',
    ]);

    $data = $request->only('titulo', 'descripcion', 'video_url');

    // Si suben nueva miniatura, subir y actualizar ruta
    if ($request->hasFile('miniatura')) {
        // Opcional: eliminar la miniatura anterior aquí si quieres
        $data['miniatura'] = $request->file('miniatura')->store('grabaciones', 'public');
    }

    $grabacion->update($data);

    return redirect()->route('admin.grabaciones.index')->with('success', 'Grabación actualizada correctamente.');
}

}
