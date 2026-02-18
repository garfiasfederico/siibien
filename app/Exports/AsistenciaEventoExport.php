<?php
namespace App\Exports;

use App\Models\Evento;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AsistenciaEventoExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected Evento $evento;

    public function __construct(Evento $evento)
    {
        $this->evento = $evento;
    }

    public function query()
    {
        return DB::table('asistencia_eventos as a')
            ->join('registros as r', 'r.idRegistro', '=', 'a.idRegistro')
            ->leftJoin('dependencia as d', 'd.idDependencia', '=', 'r.idDependencia')
            ->where('a.idEvento', $this->evento->idEvento)
            ->select([
                'a.idAsistencia',
                DB::raw("COALESCE(d.dependenciaSiglas, d.dependenciaNombre) AS dependencia"),
                'r.nombre as personaNombre',
                'r.cargo',
                'r.email',
                'r.telefono',
                DB::raw("DATE_FORMAT(a.scanned_at, '%Y-%m-%d %H:%i:%s') as checkin_at"),
            ])
            ->orderBy('a.scanned_at', 'asc');
    }

    public function headings(): array
    {
        return [
            'ID Asistencia',
            'Dependencia',
            'Nombre',
            'Cargo',
            'Email',
            'Teléfono',
            'Check-in',
        ];
    }

    public function map($row): array
    {
        return [
            $row->idAsistencia,
            (string)($row->dependencia ?? '—'),
            (string)($row->personaNombre ?? ''),
            (string)($row->cargo ?? ''),
            (string)($row->email ?? ''),
            (string)($row->telefono ?? ''),
            (string)($row->checkin_at ?? ''),
        ];
    }
}
