<?php

namespace App\Exports;

use App\Models\RegistroWebinarParticipante;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class InscripcionesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Trae todos los registros de participantes junto con el webinar
        return RegistroWebinarParticipante::with('webinar')->get();
    }

    public function headings(): array
    {
        return [
            'ID Registro',
            'Nombre',
            'Apellido',
            'Teléfono',
            'Documento Identidad',
            'Sexo',
            'Grupo Poblacional',
            'Etnia',
            'Título del Webinar',
            'Fecha del Webinar',
            'Hora de Inicio',
        ];
    }

    public function map($registro): array
    {
        return [
            $registro->id,
            $registro->nombre ?? '-',
            $registro->apellido ?? '-',
            $registro->telefono ?? '-',
            $registro->documento_identidad ?? '-',
            $registro->sexo ?? '-',
            $registro->grupo_poblacional ?? '-',
            $registro->etnia ?? '-',
            $registro->webinar->titulo ?? '-',
            $registro->webinar?->fecha
                ? Carbon::parse($registro->webinar->fecha)->format('d/m/Y')
                : '-',
            $registro->webinar?->hora_inicio
                ? Carbon::parse($registro->webinar->hora_inicio)->format('H:i')
                : '-',
        ];
    }
}
