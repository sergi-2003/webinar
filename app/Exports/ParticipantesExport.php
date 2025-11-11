<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ParticipantesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::select(
            'nombre',
            'email',
            'role',
            'fecha_registro',
            'telefono',
            
        )->get();
    }

    public function headings(): array
    {
        return [
            'nombre',
            'email',
            'role',
            'fecha_registro',
            'telefono',
        ];
    }
}
