<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Webinar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WebinarController extends Controller
{
    /** 📋 Listar webinars */
    public function index(Request $request)
    {
        $this->actualizarEstadosWebinars(); // 👈 Actualiza estados automáticamente

        $estado = $request->query('estado'); // proximo | en_vivo | finalizado
        $q = $request->query('q');

        $query = Webinar::query()->with('creador');

        // 🔍 Búsqueda
        if (!empty($q)) {
            $query->where(function ($sub) use ($q) {
                $sub->where('titulo', 'like', "%{$q}%")
                    ->orWhere('descripcion', 'like', "%{$q}%");
            });
        }

        // 🎯 Filtro por estado
        if (!empty($estado) && in_array($estado, ['proximo', 'en_vivo', 'finalizado'])) {
            $query->where('estado', $estado);
        }

        $webinars = $query->orderBy('fecha', 'desc')->paginate(12)->withQueryString();

        return view('admin.webinars.index', compact('webinars'));
    }

    /** ➕ Formulario de creación */
    public function create()
    {
        return view('admin.webinars.create');
    }

    /** 💾 Guardar nuevo webinar */
   public function store(Request $request)
{
    $request->validate([
        'titulo' => 'required|string|max:255',
        'descripcion' => 'required|string',
        'fecha' => 'required|date',
        'estado' => 'required|in:proximo,en_vivo,finalizado',
        'password' => 'nullable|string|max:50',
        'duracion' => 'nullable|integer|min:1'
    ]);

    $slug = str_replace(' ', '_', $request->titulo);
    $uniqueId = uniqid();
    $videoUrl = "https://meet.jit.si/{$slug}_{$uniqueId}";

    $fechaInicio = Carbon::parse($request->fecha);
    $horaFin = $fechaInicio->copy()->addMinutes((int) $request->input('duracion', 60));

    Webinar::create([
        'titulo' => $request->titulo,
        'descripcion' => $request->descripcion,
        'fecha' => $fechaInicio,
        'hora_fin' => $horaFin,
        'estado' => $request->estado,
        'video_url' => $videoUrl,
        'creado_por' => Auth::id(),
        'password' => $request->password,
        'privado' => !empty($request->password),
    ]);

    return redirect()->route('admin.webinars.index')
        ->with('success', '✅ Webinar creado correctamente.');
}

    /** ✏️ Formulario de edición */
    public function edit($id)
    {
        $webinar = Webinar::findOrFail($id);
        return view('admin.webinars.edit', compact('webinar'));
    }

    /** 🔄 Actualizar webinar existente */
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'estado' => 'required|in:proximo,en_vivo,finalizado',
            'video_url' => 'nullable|url',
            'password' => 'nullable|string|max:50',
            'duracion' => 'nullable|integer|min:1'
        ]);

        $webinar = Webinar::findOrFail($id);

        // 🕒 Recalcular hora_fin si hay nueva duración
        $horaFin = Carbon::parse($request->fecha)->addMinutes($request->input('duracion', 60));

        // Mantener URL actual o usar la nueva
        $videoUrl = $request->video_url ?: $webinar->video_url;

        // Si hay contraseña, agregamos fragmento y marcamos privado
        $isPrivado = $request->filled('password');
        if ($isPrivado) {
            $videoUrl = preg_replace('/#.*$/', '', $videoUrl); // limpia fragmento anterior
            $videoUrl .= "#config.password=" . urlencode($request->password);
        }

        $webinar->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha' => $request->fecha,
            'hora_fin' => $horaFin,
            'estado' => $request->estado,
            'video_url' => $videoUrl,
            'password' => $request->password,
            'privado' => $isPrivado,
        ]);

        return redirect()
            ->route('admin.webinars.index')
            ->with('success', '✅ Webinar actualizado correctamente.');
    }

    /** 🗑️ Eliminar webinar */
    public function destroy(Webinar $webinar)
    {
        $webinar->delete();

        return redirect()
            ->route('admin.webinars.index')
            ->with('success', '🗑️ Webinar eliminado correctamente.');
    }

    /**
     * 🧠 Función privada: Actualiza automáticamente los estados.
     */
    private function actualizarEstadosWebinars()
    {
        $ahora = Carbon::now();

        Webinar::where('fecha', '>', $ahora)
            ->update(['estado' => 'proximo']);

        Webinar::where('fecha', '<=', $ahora)
            ->where('fecha', '>=', $ahora->copy()->subHour())
            ->update(['estado' => 'en_vivo']);

        Webinar::where('fecha', '<', $ahora->copy()->subHour())
            ->update(['estado' => 'finalizado']);
    }

    /** 🔒 Acceso a webinar privado */
    public function acceder($id)
    {
        $webinar = Webinar::findOrFail($id);

        if (!$webinar->privado) {
            return redirect()->away($webinar->video_url);
        }

        return view('cliente.webinars.acceder', compact('webinar'));
    }

    /** ✅ Validar contraseña de acceso */
    public function validarAcceso(Request $request, $id)
{
    $webinar = Webinar::findOrFail($id);

    if ($webinar->password && $webinar->password === $request->input('password')) {
        // ✅ En lugar de mostrar el link con la contraseña, lo llevamos a una vista segura
        return view('cliente.webinars.ver', compact('webinar'));
    }

    return back()->withErrors(['password' => '❌ Contraseña incorrecta.'])->withInput();
}
}
