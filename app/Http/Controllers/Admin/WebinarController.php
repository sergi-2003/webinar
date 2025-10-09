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
    $this->actualizarEstadosWebinars(); // 👈 Llama aquí la función automática

    $estado = $request->query('estado'); // proximo | en_vivo | finalizado
    $q = $request->query('q');

    $now = Carbon::now();

    $query = Webinar::query()->with('creador');

    // 🔍 Búsqueda por título/descripcion
    if (!empty($q)) {
        $query->where(function($sub) use ($q) {
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
    ]);

    $slug = str_replace(' ', '_', $request->titulo);
    $uniqueId = uniqid();
    $videoUrl = "https://meet.jit.si/{$slug}_{$uniqueId}";

    // 🔑 Si hay contraseña, la agregamos como parámetro de Jitsi
    if ($request->password) {
        $videoUrl .= "#password=" . urlencode($request->password);
    }

    Webinar::create([
        'titulo' => $request->titulo,
        'descripcion' => $request->descripcion,
        'fecha' => $request->fecha,
        'estado' => $request->estado,
        'video_url' => $videoUrl,
        'creado_por' => Auth::id(),
        'password' => $request->password, // opcional, guardamos para referencia
    ]);

    return redirect()->route('admin.webinars.index')
        ->with('success', '✅ Webinar creado con enlace Jitsi y contraseña opcional.');
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
        ]);

        $webinar = Webinar::findOrFail($id);

        $videoUrl = $webinar->video_url; // no cambiar URL si ya existe
if(!empty($request->password)){
    $videoUrl .= "#config.password={$request->password}";
}

        $webinar->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha' => $request->fecha,
            'estado' => $request->estado,
            'video_url' => $request->video_url,
            'password' => $request->password,
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
     * 🧠 Función privada: Actualiza automáticamente los estados de los webinars.
     * 
     * 🔹 Lógica:
     *  - Si la fecha es futura → estado = 'proximo'
     *  - Si está ocurriendo (ahora ±1h) → estado = 'en_vivo'
     *  - Si ya pasó hace más de 1h → estado = 'finalizado'
     */
    private function actualizarEstadosWebinars()
    {
        $ahora = Carbon::now();

        // 🟡 Próximos (aún no comienzan)
        Webinar::where('fecha', '>', $ahora)
            ->update(['estado' => 'proximo']);

        // 🟢 En vivo (entre hace 1h y ahora)
        Webinar::where('fecha', '<=', $ahora)
            ->where('fecha', '>=', $ahora->copy()->subHour())
            ->update(['estado' => 'en_vivo']);

        // 🔴 Finalizados (más de 1h después de su hora)
        Webinar::where('fecha', '<', $ahora->copy()->subHour())
            ->update(['estado' => 'finalizado']);
    }
}
