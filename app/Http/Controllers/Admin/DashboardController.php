<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Webinar;
use App\Models\Inscripcion;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 🔄 Actualizamos estados antes de cargar
        $this->actualizarEstadosWebinars();

        // 📊 Métricas principales
        $totalWebinars = Webinar::count();
        $activeWebinars = Webinar::where('estado', 'en_vivo')->count();
        $proximosWebinars = Webinar::where('estado', 'proximo')->count();
        $inactiveWebinars = Webinar::where('estado', 'finalizado')->count();
        $totalUsers = User::count();

        // 📈 Inscripciones
        $totalInscripciones = Inscripcion::count();
        $promedioAsistentes = $totalWebinars > 0 
            ? $totalInscripciones / $totalWebinars 
            : 0;

        // 🕒 Últimos registros
        $ultimosWebinars = Webinar::orderBy('fecha', 'desc')->take(5)->get();

        $ultimosUsuarios = User::orderBy('fecha_registro', 'desc')->take(5)->get();


        // 📅 Datos para gráfica de tendencia (últimos 6 meses)
        $dataPorMes = Webinar::select(
                DB::raw('MONTH(fecha) as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->where('fecha', '>=', Carbon::now()->subMonths(6))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $labels = [];
        $data = [];
        foreach ($dataPorMes as $item) {
            $labels[] = Carbon::create()->month($item->mes)->locale('es')->monthName;
            $data[] = $item->total;
        }

        return view('admin.dashboard', compact(
            'totalWebinars',
            'activeWebinars',
            'proximosWebinars',
            'inactiveWebinars',
            'totalUsers',
            'totalInscripciones',
            'promedioAsistentes',
            'labels',
            'data',
            'ultimosWebinars',
            'ultimosUsuarios'
        ));
    }

    /**
     * 🕐 Actualiza automáticamente el estado de los webinars según la fecha actual
     */
    private function actualizarEstadosWebinars()
    {
        $ahora = Carbon::now();

        // Próximos
        Webinar::where('fecha', '>', $ahora)
            ->update(['estado' => 'proximo']);

        // En vivo (ahora ± 1 hora)
        Webinar::whereBetween('fecha', [
                $ahora->copy()->subHour(),
                $ahora->copy()->addHour()
            ])
            ->update(['estado' => 'en_vivo']);

        // Finalizados (más de 1h después de iniciar)
        Webinar::where('fecha', '<', $ahora->copy()->subHour())
            ->update(['estado' => 'finalizado']);
    }
}
