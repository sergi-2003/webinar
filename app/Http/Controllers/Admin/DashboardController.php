<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Webinar;
use App\Models\RegistroWebinarParticipante;
use App\Models\Inscripcion;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // === Totales principales ===
        $totalUsers = User::count();
        $totalWebinars = Webinar::count();
        $totalInscripciones = Inscripcion::count();

        // === Asistentes únicos y promedio por webinar ===
        $asistentesPorWebinar = RegistroWebinarParticipante::select(
            'webinar_id',
            DB::raw('COUNT(DISTINCT usuario_id) as total')
        )
        ->groupBy('webinar_id')
        ->pluck('total');

        $totalAsistentes = RegistroWebinarParticipante::distinct('usuario_id')->count('usuario_id');

        $promedioAsistentes = $asistentesPorWebinar->count() > 0
            ? round($asistentesPorWebinar->sum() / $asistentesPorWebinar->count(), 1)
            : 0;

        // === Distribución por sexo ===
        $porSexo = RegistroWebinarParticipante::select('sexo', DB::raw('COUNT(*) as total'))
            ->groupBy('sexo')
            ->pluck('total', 'sexo');

        // === Distribución por grupo poblacional ===
        $porGrupo = RegistroWebinarParticipante::select('grupo_poblacional', DB::raw('COUNT(*) as total'))
            ->groupBy('grupo_poblacional')
            ->pluck('total', 'grupo_poblacional');

        // === Distribución por etnia ===
        $porEtnia = RegistroWebinarParticipante::select('etnia', DB::raw('COUNT(*) as total'))
            ->groupBy('etnia')
            ->pluck('total', 'etnia');

        // === Distribución por rango de edad ===
        $porEdad = RegistroWebinarParticipante::selectRaw("
                CASE
                    WHEN edad < 18 THEN 'Menor de 18'
                    WHEN edad BETWEEN 18 AND 25 THEN '18-25'
                    WHEN edad BETWEEN 26 AND 35 THEN '26-35'
                    WHEN edad BETWEEN 36 AND 45 THEN '36-45'
                    WHEN edad BETWEEN 46 AND 60 THEN '46-60'
                    ELSE 'Mayor de 60'
                END as rango,
                COUNT(*) as total
            ")
            ->groupBy('rango')
            ->orderByRaw("
                FIELD(rango, 'Menor de 18', '18-25', '26-35', '36-45', '46-60', 'Mayor de 60')
            ")
            ->pluck('total', 'rango');

        // === Tendencia mensual de inscripciones (últimos 6 meses) ===
        $tendenciaInscripciones = Inscripcion::select(
                DB::raw('MONTH(fecha_inscripcion) as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->where('fecha_inscripcion', '>=', now()->subMonths(6))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $meses = [];
        $totalesMes = [];
        foreach ($tendenciaInscripciones as $item) {
            $meses[] = ucfirst(Carbon::create()->month($item->mes)->locale('es')->monthName);
            $totalesMes[] = $item->total;
        }

        // === Tabla resumen por webinar ===
        $tablaWebinars = Webinar::select('id', 'titulo', 'fecha')
            ->withCount(['inscripciones', 'participantes as total_participantes'])
            ->orderBy('fecha', 'desc')
            ->get()
            ->map(function ($webinar) {
                $totalInscritos = $webinar->inscripciones_count ?? 0;
                $totalPart = $webinar->total_participantes ?? 0;
                $webinar->porcentaje = $totalInscritos > 0
                    ? round(($totalPart / $totalInscritos) * 100, 1)
                    : 0;
                $webinar->fecha_formateada = Carbon::parse($webinar->fecha)->format('d/m/Y');
                return $webinar;
            });

        // === Retornar vista ===
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalWebinars',
            'totalInscripciones',
            'promedioAsistentes',
            'porSexo',
            'porGrupo',
            'porEtnia',
            'porEdad',
            'meses',
            'totalesMes',
            'tablaWebinars'
        ));
    }

    /**
     * 🕐 Actualiza automáticamente el estado de los webinars según la fecha actual
     */
    private function actualizarEstadosWebinars()
    {
        $ahora = Carbon::now();

        Webinar::where('fecha', '>', $ahora)->update(['estado' => 'proximo']);

        Webinar::whereBetween('fecha', [
            $ahora->copy()->subHour(),
            $ahora->copy()->addHour()
        ])->update(['estado' => 'en_vivo']);

        Webinar::where('fecha', '<', $ahora->copy()->subHour())
            ->update(['estado' => 'finalizado']);
    }
}
