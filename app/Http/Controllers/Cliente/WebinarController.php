<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Webinar;
use App\Models\Inscripcion;
use App\Mail\ConfirmacionInscripcion;
use Illuminate\Support\Facades\Mail;


use Illuminate\Http\Request;

class WebinarController extends Controller
{
    /** 🏠 Muestra todos los webinars disponibles */
 public function index(Request $request)
{
    $query = Webinar::query()
        ->where('activo', true); // 👈 Mostrar solo los webinars activos

    if ($request->filled('q')) {
        $query->where('titulo', 'like', '%' . $request->q . '%');
    }

    if ($request->filled('estado')) {
        $query->where('estado', $request->estado);
    }

    $webinars = $query->orderBy('fecha', 'desc')->get();

    if ($request->ajax()) {
        return view('cliente.webinars.partials.lista', compact('webinars'))->render();
    }

    return view('cliente.webinars.index', compact('webinars'));
}

 public function misConferencias()
    {
        // Asegurarse de que el usuario esté autenticado
        if (!auth()->check()) {
            return redirect()->route('login')->with('warning', 'Necesitas iniciar sesión para ver tus conferencias.');
        }

        $userId = auth()->id();

        // Obtener todas las inscripciones del usuario actual
        $inscripciones = Inscripcion::with('webinar')
            ->where('usuario_id', $userId)
            ->get();

        // Extraer los objetos Webinar de las inscripciones
        $webinars = $inscripciones->map(function ($inscripcion) {
            return $inscripcion->webinar;
        })->filter()->sortByDesc('fecha'); // Filtrar nulos y ordenar por fecha

        // Devolver la vista donde se mostrarán las conferencias inscritas
        return view('cliente.webinars.mis_conferencias', compact('inscripciones'));
    }

    /** 🔒 Formulario de acceso para webinars privados */
public function acceder($id)
{
    $webinar = Webinar::findOrFail($id);

    // 🔒 Si el webinar aún no está activo
    if (!$webinar->activo) {
        return redirect()->back()->with('warning', '⏳ El webinar aún no está disponible. Espera que el administrador lo inicie.');
    }

    // 🔐 Si es privado, verificar si el usuario ya validó contraseña
    if ($webinar->privado && !session()->get('webinar_acceso_'.$id)) {
        return redirect()->route('cliente.webinars.password', $id)
                         ->with('info', 'Este webinar es privado. Ingresa la contraseña para acceder.');
    }

    // ✅ Si está activo y público o autorizado, redirige al enlace
    if ($webinar->video_url) {
        return redirect()->away($webinar->video_url);
    }

    // 🚨 Si no tiene enlace definido
    return redirect()->back()->with('error', 'No se ha configurado un enlace para este webinar.');
}


    // Validar la contraseña (POST)
    public function validarAcceso(Request $request, $id)
    {
        $webinar = Webinar::findOrFail($id);

        $request->validate([
            'password' => 'required|string'
        ]);

        // Comparar con la contraseña del webinar
        if ($request->password === ($webinar->password ?? 'webinar'.$webinar->id)) {
            // Guardar en sesión que el usuario tiene acceso
            session()->put('webinar_acceso_'.$id, true);

            return redirect()->route('cliente.webinars.acceder', $id)
                             ->with('success', 'Contraseña correcta. Accediendo al webinar...');
        }

        return redirect()->route('cliente.webinars.acceder')
                         ->with('error', 'Contraseña incorrecta, inténtalo de nuevo.');
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


public function inscribir($id)
{
    $user = auth()->user();
    $webinar = Webinar::findOrFail($id);

    // ✅ Evitar duplicados
    if ($user->inscripciones()->where('webinar_id', $webinar->id)->exists()) {
        return redirect()->back()->with('info', 'Ya estás inscrito en este webinar.');
    }

    // ✅ Crear inscripción
    Inscripcion::create([
        'usuario_id' => $user->id, 
        'webinar_id' => $webinar->id,
    ]);

    // (Opcional) Enviar correo de confirmación
    // Mail::to($user->email)->send(new ConfirmacionInscripcion($webinar, $user));

    return redirect()->back()->with('success', 'Inscripción registrada correctamente.');
}

public function cancelarInscripcion($id)
{
    $inscripcion = \App\Models\Inscripcion::findOrFail($id);

    // Asegurar que la inscripción pertenece al usuario actual
    if ($inscripcion->usuario_id !== auth()->id()) {
        abort(403, 'No tienes permiso para cancelar esta inscripción.');
    }

    $inscripcion->delete();

    return redirect()->back()->with('success', 'Tu inscripción ha sido cancelada correctamente.');
}

public function verificarEstado($id)
{
    $webinar = Webinar::findOrFail($id);
    return response()->json(['activo' => (bool) $webinar->activo]);
}

public function registrarParticipante(Request $request, $id)
{
    // ✅ Validación del formulario
    $validated = $request->validate([
        'nombre' => 'required|string|max:100',
        'apellido' => 'required|string|max:100',
        'telefono' => 'nullable|string|max:20',
        'documento_identidad' => 'required|string|max:50',
        'grupo_poblacional' => 'required|string|max:100',
        'etnia' => 'required|string|max:100',
        'sexo' => 'required|string|max:20',
         'edad' => 'required|string|max:100',
        'comuna' => 'required|string|max:100',
        'barrio' => 'required|string|max:20'
    ]);

    $webinar = \App\Models\Webinar::findOrFail($id);
    $user = auth()->user();

    // ✅ Verificar si ya está inscrito
    $yaInscrito = \App\Models\Inscripcion::where('usuario_id', $user->id)
        ->where('webinar_id', $webinar->id)
        ->exists();

    if ($yaInscrito) {
        return response()->json([
            'success' => false,
            'message' => 'Ya estás inscrito en este webinar.'
        ]);
    }

    // ✅ Crear inscripción
    \App\Models\Inscripcion::create([
        'usuario_id' => $user->id,
        'webinar_id' => $webinar->id,
        'fecha_inscripcion' => now(),
        'estado' => 'inscrito',
    ]);

    // ✅ Registrar participante con usuario_id
    if (class_exists(\App\Models\RegistroWebinarParticipante::class)) {
        $validated['webinar_id'] = $webinar->id;
        $validated['usuario_id'] = $user->id; // 👈 ESTA LÍNEA ES LA CLAVE
        \App\Models\RegistroWebinarParticipante::create($validated);
    }

    return response()->json([
        'success' => true,
        'message' => '✅ Registro guardado correctamente. Estarás habilitado cuando el webinar comience.',
        'url' => null,
    ]);
}

/** 📋 Muestra el formulario de contraseña para webinars privados */
public function password($id)
{
    $webinar = Webinar::findOrFail($id);
    return view('cliente.webinars.password', compact('webinar'));
}

}
