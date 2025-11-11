<?php

namespace App\Exports;

use App\Models\RegistroWebinarParticipante;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class WebinarsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Trae los registros con sus relaciones
        return RegistroWebinarParticipante::with(['webinar', 'usuario'])->get();
    }

    public function map($p): array
    {
        return [
            $p->webinar->titulo ?? 'Sin título',
            $p->usuario->nombre ?? $p->nombre ?? '-',
            $p->usuario->email ?? '-',
            $p->documento_identidad ?? '-',
            $p->grupo_poblacional ?? '-',
            $p->etnia ?? '-',
            $p->sexo ?? '-',
            optional($p->created_at)->format('d/m/Y H:i') ?? '-',
        ];
    }

    public function headings(): array
    {
        return [
            'Webinar',
            'Nombre',
            'Correo',
            'Documento',
            'Grupo Poblacional',
            'Etnia',
            'Sexo',
            'Fecha Registro',
        ];
    }
}
