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
        $detallado = DB::select("SELECT informe_acciones.id,informe_acciones.nombre,dependencia.dependenciaSiglas as responsable, if(informe_acciones.prioritario=0,'no','si') as prioritario, CONCAT(ejeped.ejePEDClave,' ',ejeped.ejePEDDescripcion) as eje,
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
                                ia_bs_entregas.r4,
                                ia_bs_poblacion.ph1 as progH1er,
                                ia_bs_poblacion.ah1 as atenH1er,
                                ia_bs_poblacion.ph2 as progH2do,
                                ia_bs_poblacion.ah2 as atenH2do,
                                ia_bs_poblacion.ph3 as progH3er,
                                ia_bs_poblacion.ah3 as atenH3er,
                                ia_bs_poblacion.ph4 as progH4to,
                                ia_bs_poblacion.ah4 as atenH4to,
                                
                                ia_bs_poblacion.pm1 as progM1er,
                                ia_bs_poblacion.am1 as atenM1er,
                                ia_bs_poblacion.pm2 as progM2do,
                                ia_bs_poblacion.am2 as atenM2do,
                                ia_bs_poblacion.pm3 as progM3er,
                                ia_bs_poblacion.am3 as atenM3er,
                                ia_bs_poblacion.pm4 as progM4to,
                                ia_bs_poblacion.am4 as atenM4to,
                                (select GROUP_CONCAT(programa_presupuestario.clavePrograma,' ',programa_presupuestario.descripcionPrograma, '|Componente: ',ia_bs_presupuesto.componente, '|',e1,'|',e2,'|',e3,'|',e4 SEPARATOR '\n') FROM ia_bs_presupuesto INNER JOIN programa_presupuestario ON programa_presupuestario.idPrograma = ia_bs_presupuesto.idPrograma WHERE ia_bs_presupuesto.idBS = ia_bs.idBS AND ia_bs_presupuesto.anio= ia_bs_entregas.anio and tipo='o') as programasOperativos,                                
                                (select sum(e1+e2+e3+e4) from ia_bs_presupuesto where ia_bs.idBS = ia_bs_presupuesto.idBS AND ia_bs_presupuesto.anio= ia_bs_entregas.anio AND ia_bs_presupuesto.tipo='o') as ejercidoOperativo,
                                (select GROUP_CONCAT(programa_presupuestario.clavePrograma,' ',programa_presupuestario.descripcionPrograma, '|Componente: ',ia_bs_presupuesto.componente, '|',e1,'|',e2,'|',e3,'|',e4 SEPARATOR '\n') FROM ia_bs_presupuesto INNER JOIN programa_presupuestario ON programa_presupuestario.idPrograma = ia_bs_presupuesto.idPrograma WHERE ia_bs_presupuesto.idBS = ia_bs.idBS AND ia_bs_presupuesto.anio=  ia_bs_entregas.anio and tipo='i') as programasInversion,
                                (select sum(e1+e2+e3+e4) from ia_bs_presupuesto where ia_bs.idBS = ia_bs_presupuesto.idBS AND ia_bs_presupuesto.anio= ia_bs_entregas.anio AND ia_bs_presupuesto.tipo='i') as ejercidoInversion
                        FROM ia_bs 
                        INNER JOIN informe_acciones ON informe_acciones.id = ia_bs.ia_id
                        LEFT JOIN temaped on temaped.idTemaPED = informe_acciones.idTemaPED
                        LEFT JOIN ejeped on ejeped.idEjePED = temaped.idEjePED
                        LEFT JOIN ia_alineacion on ia_alineacion.ia_id = informe_acciones.id
                        LEFT JOIN sectores on sectores.idSector = ia_alineacion.idSector
                        LEFT JOIN ia_bs_entregas ON ia_bs_entregas.idBS = ia_bs.idBS
                        LEFT JOIN ia_bs_poblacion ON ia_bs.idBS = ia_bs_poblacion.idBS
                        INNER JOIN dependencia ON dependencia.idDependencia = informe_acciones.idDependencia");
                        
                        return (collect($detallado));
    }

    public function headings():array{
        return [
            "idPPA",
            "nombrePPA",
            "responsable",
            "prioritario",
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
            "r4",
            "progH1er",
            "atenH1er",
            "progH2do",
            "atenH2do",
            "progH3er",
            "atenH3er",
            "progH4to",
            "atenH4to",
            
            "progM1er",
            "atenM1er",
            "progM2do",
            "atenM2do",
            "progM3er",
            "atenM3er",
            "progM4to",
            "atenM4to",

            "programasOperativos",
            "ejercidoOperativo",
            "programasInversion",
            "ejercidoInversion"
        ];
    }
}
