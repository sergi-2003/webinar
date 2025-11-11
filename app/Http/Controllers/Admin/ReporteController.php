<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\ParticipantesExport;
use App\Exports\InscripcionesExport;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    public function index()
    {
        return view('admin.reportes.index');
    }

    public function exportParticipantes()
    {
        return Excel::download(new ParticipantesExport, 'participantes.xlsx');
    }

    public function exportInscripciones()
    {
        return Excel::download(new InscripcionesExport, 'inscripciones.xlsx');
    }
}
