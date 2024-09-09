<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class CumplimientoInformeExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        $detallado = DB::select('select dependencia.dependenciaSiglas,temaped.temaPEDClave,temaped.temaPEDDescripcion, matriz_coordinacion.tipo,
                (select count(*)
                FROM informe_parrafos
                INNER JOIN informe_acciones ON informe_acciones.id = informe_parrafos.informe_acciones_id
                INNER JOIN temaped ON temaped.idTemaPED = informe_acciones.idTemaPED
                INNER JOIN dependencia ON dependencia.idDependencia = informe_acciones.idDependencia
                WHERE informe_acciones.idTemaPED = matriz_coordinacion.idTemaPED AND informe_acciones.idDependencia = matriz_coordinacion.dependencias_id
                GROUP BY temaped.temaPEDClave, dependencia.dependenciaSiglas) as "parrafos",
                (select informe_parrafos.updated_at
                FROM informe_parrafos
                INNER JOIN informe_acciones ON informe_acciones.id = informe_parrafos.informe_acciones_id
                INNER JOIN temaped ON temaped.idTemaPED = informe_acciones.idTemaPED
                INNER JOIN dependencia ON dependencia.idDependencia = informe_acciones.idDependencia
                WHERE informe_acciones.idTemaPED = matriz_coordinacion.idTemaPED AND informe_acciones.idDependencia = matriz_coordinacion.dependencias_id
                ORDER BY informe_parrafos.updated_at DESC limit 1) as "Última actualización"
                FROM matriz_coordinacion
                INNER JOIN dependencia ON dependencia.idDependencia = matriz_coordinacion.dependencias_id
                INNER JOIN temaped ON temaped.idTemaPED = matriz_coordinacion.idTemaPED;'
        );

        return (collect($detallado));
    }

    public function headings():array{
        return [
            "Dependencia",
            "Tema Clave",
            "Tema Descripción",
            "Rol",
            "Parrafos Capturados",
            "Ultima actualización"
        ];
    }
}
