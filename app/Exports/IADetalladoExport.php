<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class IADetalladoExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $detallado = DB::select("SELECT informe_acciones.id,informe_acciones.nombre,dependencia.dependenciaSiglas as responsable, CONCAT(ejeped.ejePEDClave,' ',ejeped.ejePEDDescripcion) as eje,
                                CONCAT(temaped.temaPEDClave,' ',temaped.temaPEDDescripcion) as tema,
                                ia_alineacion.lineas,
                                CONCAT(sectores.claveSector,' ',sectores.sector) as sector,
                                ia_bs.idBS,
                                ia_bs.nombreBS,ia_bs.descripcionBS,
                                ia_bs_entregas.anio,
                                ia_bs_entregas.p1,
                                ia_bs_entregas.p2,
                                ia_bs_entregas.p3,
                                ia_bs_entregas.p4,
                                ia_bs_entregas.r1,
                                ia_bs_entregas.r2,
                                ia_bs_entregas.r3,
                                ia_bs_entregas.r4
                        FROM ia_bs 
                        INNER JOIN informe_acciones ON informe_acciones.id = ia_bs.ia_id
                        LEFT JOIN temaped on temaped.idTemaPED = informe_acciones.idTemaPED
                        LEFT JOIN ejeped on ejeped.idEjePED = temaped.idEjePED
                        LEFT JOIN ia_alineacion on ia_alineacion.ia_id = informe_acciones.id
                        LEFT JOIN sectores on sectores.idSector = ia_alineacion.idSector
                        LEFT JOIN ia_bs_entregas ON ia_bs_entregas.idBS = ia_bs.idBS
                        INNER JOIN dependencia ON dependencia.idDependencia = informe_acciones.idDependencia");
                        
                        return (collect($detallado));
    }

    public function headings():array{
        return [
            "idPPA",
            "nombrePPA",
            "responsable",
            "eje",
            "tema",
            "lineas",
            "sector",
            "idBS",
            "nombreBS",
            "descripcionBS",
            "anio",
            "p1",
            "p2",
            "p3",
            "p4",
            "r1",
            "r2",
            "r3",
            "r4"
        ];
    }
}
