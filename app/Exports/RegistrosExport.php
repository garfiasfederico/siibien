<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RegistrosExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection(): Collection
    {
        $q = DB::table('registros as r')
            ->leftJoin('dependencia as d', 'd.idDependencia', '=', 'r.idDependencia')
            ->select([
                'r.idRegistro',
                'r.idDependencia',
                DB::raw("COALESCE(d.dependenciaSiglas, d.dependenciaNombre) AS dependencia"),
                'r.nombre',
                'r.cargo',
                'r.email',
                'r.telefono',
                'r.perfil',
                'r.tipo_enlace',
                'r.qr_uuid',
            ])
            ->orderBy('r.idRegistro')
            ->get();


        if ($q->isEmpty()) {
            return collect([]);
        }
        return $q->map(function ($r) {
            return [
                $r->idRegistro,
                $r->idDependencia,
                $r->dependencia,
                $r->nombre,
                $r->cargo,
                $r->email,
                $r->telefono,
                $r->perfil,
                $r->tipo_enlace,
                $r->qr_uuid,
            ];

        });


    }

    public function headings(): array
    {
        return [
            'ID Registro',
            'ID Dependencia',
            'Dependencia',
            'Nombre',
            'Cargo',
            'Email',
            'Teléfono',
            'Perfil',
            'Tipo Enlace',
            'QR UUID',
        ];
    }
}
