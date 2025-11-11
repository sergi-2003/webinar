<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Webinar;
use App\Models\User;
use App\Models\Inscripcion;
use App\Models\RegistroWebinarParticipante;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Exports\WebinarsExport;         
use Maatwebsite\Excel\Facades\Excel;    
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WebinarController extends Controller
{
    /** Mostrar el formulario de creación de un nuevo webinar */
    public function create()
    {
        return view('admin.webinars.create');
    }

    /** Listar todos los webinars en el panel del administrador */
    public function index(Request $request)
    {
        // Actualizamos estados antes de listar (puedes quitar esto y ejecutarlo por cron si prefieres)
        $this->actualizarEstadosWebinars();

        $estado = $request->query('estado');
        $q = $request->query('q');

        $query = Webinar::query()->with('creador');

        if (!empty($q)) {
            $query->where(function ($sub) use ($q) {
                $sub->where('titulo', 'like', "%{$q}%")
                    ->orWhere('descripcion', 'like', "%{$q}%");
            });
        }

        if (!empty($estado) && in_array($estado, ['proximo', 'en_vivo', 'finalizado'])) {
            $query->where('estado', $estado);
        }

        // Ordenar por la hora de inicio para que la lista sea cronológica
        $webinars = $query->orderBy('hora_inicio', 'desc')->paginate(12)->withQueryString();

        // Estadísticas generales
        $totalWebinars = Webinar::count();
        $activeWebinars = Webinar::where('estado', 'en_vivo')->count();
        $inactiveWebinars = Webinar::where('estado', 'finalizado')->count();
        $proximosWebinars = Webinar::where('estado', 'proximo')->count();
        $totalUsers = User::count();
        $totalInscripciones = Inscripcion::count() ?? 0;
        $promedioAsistentes = $totalWebinars > 0 ? $totalInscripciones / $totalWebinars : 0;

        // Datos para gráficas (usamos la columna fecha)
        $labels = Webinar::selectRaw('MONTH(fecha) as mes')
            ->groupBy('mes')
            ->pluck('mes')
            ->map(fn($m) => Carbon::create()->month($m)->format('M'));

        $data = Webinar::selectRaw('COUNT(*) as total, MONTH(fecha) as mes')
            ->groupBy('mes')
            ->pluck('total');

        $ultimosWebinars = Webinar::orderBy('hora_inicio', 'desc')->take(5)->get();
        $ultimosUsuarios = User::orderBy('id', 'desc')->take(5)->get();

        return view('admin.webinars.index', compact(
            'webinars',
            'totalWebinars',
            'activeWebinars',
            'inactiveWebinars',
            'proximosWebinars',
            'totalUsers',
            'totalInscripciones',
            'promedioAsistentes',
            'labels',
            'data',
            'ultimosWebinars',
            'ultimosUsuarios'
        ));
    }

    /** Guardar un nuevo webinar */
public function store(Request $request)
{
    $request->validate([
        'titulo' => 'required|string|max:255',
        'descripcion' => 'required|string',
        'fecha' => 'required|date',
        'duracion' => 'required|integer|min:1',
        'estado' => 'nullable|in:proximo,en_vivo,finalizado',
        'password' => 'nullable|string|max:50',
        'video_url' => 'nullable|url',
    ]);

    $horaInicio = Carbon::parse($request->fecha);
    $duracion = (int) $request->duracion;
    $horaFin = $horaInicio->copy()->addMinutes($duracion);

    // Determinar el estado automáticamente si no se envía
    $estado = $request->input('estado') ?? $this->calcularEstadoPara($horaInicio, $horaFin);

    // Linnk del meet
   $videoUrl = $request->input('video_url');

    // Crear el webinar en la base de datos
    Webinar::create([
        'titulo' => $request->titulo,
        'descripcion' => $request->descripcion,
        'fecha' => $horaInicio->format('Y-m-d H:i:s'),
        'hora_inicio' => $horaInicio,
        'hora_fin' => $horaFin,
        'duracion' => $duracion,
        'estado' => $estado,
        'video_url' => $videoUrl,
        'creado_por' => Auth::id(),
        'privado' => $request->has('privado') ? 1 : 0,
        'password' => $request->has('privado') ? $request->password : null,
        'activo' => false,
    ]);

    return redirect()->route('admin.webinars.index')
        ->with('success', 'Webinar creado correctamente. El enlace de la reunion se activará cuando el anfitrión entre.');
}


    /** Actualizar un webinar existente */
   public function update(Request $request, $id)
{
    $request->validate([
        'titulo' => 'required|string|max:255',
        'descripcion' => 'required|string',
        'hora_inicio' => 'required|date', 
        'duracion' => 'required|integer|min:1',
        'estado' => 'nullable|in:proximo,en_vivo,finalizado',
        'video_url' => 'nullable|url',
        'password' => 'nullable|string|max:50',
    ]);

    $webinar = Webinar::findOrFail($id);

    // 🕒 Calcular horas
    $horaInicio = Carbon::parse($request->hora_inicio)->seconds(0);
    $duracion = (int) $request->duracion;
    $horaFin = $horaInicio->copy()->addMinutes($duracion);

    // 📅 Determinar estado automático (si no lo elige el admin)
    $estado = $request->input('estado') ?? $this->calcularEstadoPara($horaInicio, $horaFin);

    // 🔒 Si el admin deja la contraseña vacía, se conserva la anterior
    $password = $request->filled('password') ? $request->password : $webinar->password;

       // 🔐 Mantener privacidad anterior si no se envía el checkbox
     $privado = $request->has('privado') ? 1 : $webinar->privado;

    $webinar->update([
        'titulo' => $request->titulo,
        'descripcion' => $request->descripcion,
        'fecha' => $horaInicio->format('Y-m-d H:i:s'),
        'hora_inicio' => $horaInicio,
        'hora_fin' => $horaFin,
        'duracion' => $duracion,
        'estado' => $estado,
        'video_url' => $request->video_url ?: $webinar->video_url,
        'password' => $password,
         'privado' => $privado,

    ]);

    return redirect()->route('admin.webinars.index')
        ->with('success', '✅ Webinar actualizado correctamente.');
}


/** Mostrar formulario de edición de un webinar existente */
public function edit($id)
{
    $webinar = Webinar::findOrFail($id);
    return view('admin.webinars.edit', compact('webinar'));
}


    /** Eliminar un webinar */
    public function destroy(Webinar $webinar)
    {
        $webinar->delete();

        return redirect()
            ->route('admin.webinars.index')
            ->with('success', 'Webinar eliminado correctamente.');
    }

public function inscribirse($id)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Debes iniciar sesión para inscribirte.');
    }

    $usuario = Auth::user();
    $webinar = Webinar::find($id);

    if (!$webinar) {
        return redirect()->back()->with('error', 'El webinar no existe o fue eliminado.');
    }

    // 🚫 Evitar duplicados
    $yaInscrito = Inscripcion::where('usuario_id', $usuario->id)
        ->where('webinar_id', $webinar->id)
        ->exists();

    if ($yaInscrito) {
        return redirect()->back()->with('error', '❌ Ya estás inscrito en este webinar.');
    }

    // ✅ Registrar inscripción
    Inscripcion::create([
        'usuario_id' => $usuario->id,
        'webinar_id' => $webinar->id,
        'fecha_inscripcion' => now(),
    ]);

    // ✅ Registrar participante en tabla registro_webinar_participante
    RegistroWebinarParticipante::create([
        'usuario_id' => $usuario->id,
        'webinar_id' => $webinar->id,
        'nombre' => $usuario->nombre,
        'apellido' => $usuario->apellido,
        'documento_identidad' => $usuario->documento_identidad,
        'sexo' => $usuario->sexo,
        'edad' => $usuario->edad, 
        'barrio' => $usuario->barrio, 
        'comuna' => $usuario->comuna,
        'grupo_poblacional' => $usuario->grupo_poblacional,
        'etnia' => $usuario->etnia,
    ]);

    return redirect()->back()->with('success', '✅ Te has inscrito correctamente al webinar.');
}


    /** Actualiza automáticamente los estados de los webinars según hora_inicio y hora_fin */
    private function actualizarEstadosWebinars()
    {
        $ahora = Carbon::now()->seconds(0);

        // Usamos chunk para no cargar todo en memoria
        Webinar::query()->chunk(200, function ($webinars) use ($ahora) {
            foreach ($webinars as $webinar) {
                // proteger contra nulls
                if (empty($webinar->hora_inicio) || empty($webinar->hora_fin)) {
                    continue;
                }

                try {
                    $inicio = Carbon::parse($webinar->hora_inicio)->seconds(0);
                    $fin = Carbon::parse($webinar->hora_fin)->seconds(0);
                } catch (\Exception $e) {
                    // si hay formato raro, lo saltamos
                    continue;
                }

                if ($ahora->lt($inicio)) {
                    $nuevoEstado = 'proximo';
                } elseif ($ahora->between($inicio, $fin)) {
                    $nuevoEstado = 'en_vivo';
                } else {
                    $nuevoEstado = 'finalizado';
                }

                if ($webinar->estado !== $nuevoEstado) {
                    $webinar->update(['estado' => $nuevoEstado]);
                }
            }
        });
    }

    /** Helper para calcular estado por hora_inicio/hora_fin sin tocar BD */
    private function calcularEstadoPara(Carbon $inicio, Carbon $fin): string
    {
        $ahora = Carbon::now()->seconds(0);

        if ($ahora->lt($inicio)) {
            return 'proximo';
        } elseif ($ahora->between($inicio, $fin)) {
            return 'en_vivo';
        } else {
            return 'finalizado';
        }
    }



public function acceder($id)
{
    $webinar = Webinar::findOrFail($id);

    // Traemos directamente los participantes del registro
    $participantes = RegistroWebinarParticipante::where('webinar_id', $webinar->id)
        ->select('nombre', 'apellido', 'documento_identidad', 'grupo_poblacional', 'etnia', 'sexo', 'created_at')
        ->orderBy('created_at', 'desc')
        ->get();

    // Si es administrador, activa el webinar
    if (auth()->user()->isAdmin('admin')) {
        $webinar->activo = true;
        $webinar->save();

        return view('admin.webinars.ver', compact('webinar', 'participantes'))
            ->with('success', 'Has activado la reunión. Los usuarios ya pueden ingresar.');
    }

    // Si no es admin, solo puede ver los detalles
    return view('admin.webinars.ver', compact('webinar', 'participantes'));
}


    /** Ver inscritos */
    public function verInscritos($id)
    {
        $webinar = Webinar::with(['inscripciones.usuario'])->findOrFail($id);
        return view('admin.webinars.inscritos', compact('webinar'));
    }

    public function mis()
    {
        $webinars = Webinar::where('creado_por', auth()->id())->get();
        return view('admin.webinars.mis', compact('webinars'));
    }

    public function toggleActivo($id)
{
    $webinar = Webinar::findOrFail($id);
    $webinar->activo = !$webinar->activo;
    $webinar->save();

    $mensaje = $webinar->activo 
        ? '✅ El webinar se ha activado correctamente. Los usuarios ya pueden ingresar.' 
        : '⛔ El webinar se ha inactivado. Los usuarios ya no podrán ingresar.';

    return redirect()->route('admin.webinars.index')->with('success', $mensaje);
}

public function mural()
{
    $webinars = Webinar::where('estado', 'finalizado')
        ->latest('fecha')
        ->get();

    return view('cliente.mural', compact('webinars'));
}
public function exportarExcel()
{
    // Excel::download(<clase exportadora>, <nombre del archivo>)
    return Excel::download(new WebinarsExport, 'reporte_webinars.xlsx');
}


}
