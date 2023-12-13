<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IndicadoresDetallesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
         $detallado = DB::select('select *,dependencia.dependenciaSiglas,
        (select GROUP_CONCAT(objetivoped.objetivoPEDClave," ",objetivoped.objetivoPEDDescripcion SEPARATOR "\n") FROM indicadorobjetivos INNER JOIN objetivoped ON objetivoped.idObjetivoPED = indicadorobjetivos.idObjetivoPED WHERE indicadorobjetivos.idIndicador = indicador.idIndicador) as Objetivos,
        (select GROUP_CONCAT(temaped.temaPEDClave," ",temaped.temaPEDDescripcion SEPARATOR "\n")from indicadorobjetivos INNER JOIN objetivoped ON objetivoped.idObjetivoPED = indicadorobjetivos.idObjetivoPED INNER JOIN temaped on temaped.idTemaPED = objetivoped.idTemaPED where indicadorobjetivos.idIndicador = indicador.idIndicador) as Temas,
        (select GROUP_CONCAT(sector.sector SEPARATOR "\n")from indicadorobjetivos INNER JOIN objetivoped ON objetivoped.idObjetivoPED = indicadorobjetivos.idObjetivoPED INNER JOIN temaped on temaped.idTemaPED = objetivoped.idTemaPED INNER JOIN sector ON sector.idSector = temaped.idSector where indicadorobjetivos.idIndicador = indicador.idIndicador) as Sectores,
        (select GROUP_CONCAT(valoresindicador.valoresProgramado SEPARATOR "\n") from valoresindicador where valoresindicador.idIndicador = indicador.idIndicador and valoresindicador.valoresAnioMedicion="2023") as P2023,
        (select GROUP_CONCAT(valoresindicador.valoresReal SEPARATOR "\n") from valoresindicador where valoresindicador.idIndicador = indicador.idIndicador and valoresindicador.valoresAnioMedicion="2023") as M2023,
        (select GROUP_CONCAT(valoresindicador.valoresProgramado SEPARATOR "\n") from valoresindicador where valoresindicador.idIndicador = indicador.idIndicador and valoresindicador.valoresAnioMedicion="2024") as P2024,
        (select GROUP_CONCAT(valoresindicador.valoresProgramado SEPARATOR "\n") from valoresindicador where valoresindicador.idIndicador = indicador.idIndicador and valoresindicador.valoresAnioMedicion="2025") as P2025,
        (select GROUP_CONCAT(valoresindicador.valoresProgramado SEPARATOR "\n") from valoresindicador where valoresindicador.idIndicador = indicador.idIndicador and valoresindicador.valoresAnioMedicion="2026") as P2026,
        (select GROUP_CONCAT(valoresindicador.valoresProgramado SEPARATOR "\n") from valoresindicador where valoresindicador.idIndicador = indicador.idIndicador and valoresindicador.valoresAnioMedicion="2027") as P2027,
        (select GROUP_CONCAT(valoresindicador.valoresProgramado SEPARATOR "\n") from valoresindicador where valoresindicador.idIndicador = indicador.idIndicador and valoresindicador.valoresAnioMedicion="2028") as P2028,
        (select GROUP_CONCAT(programaspresupuestales.clavePrograma,".-",programaspresupuestales.descripcionPrograma SEPARATOR "\n") from programaspresupuestales INNER JOIN objetivoped ON objetivoped.idObjetivoPED = programaspresupuestales.idObjetivoPED INNER JOIN indicadorobjetivos ON indicadorobjetivos.idObjetivoPED = objetivoped.idObjetivoPED where indicadorobjetivos.idIndicador=indicador.idIndicador) as Programas_P,
        (select GROUP_CONCAT(objetivos_ods.clave,"-",objetivos_ods.descripcion SEPARATOR "\n") from indicadorods
        INNER JOIN objetivos_ods ON objetivos_ods.id = indicadorods.idODS
        where indicadorods.idIndicador=indicador.idIndicador) as Objetivos_ODS
        FROM indicador INNER JOIN dependencia ON dependencia.idDependencia = indicador.idDependencia');

         return (collect($detallado));
    }

    public function headings(): array
    {
       return [
            "idIndicador",
            "indicadorNombre",
            "indicadorObjetivo",
            "indicadorTipo",
            "indicadorDimension",
            "indicadorMetodo",
            "indicadorFormula",
            "indicadorUM",
            "indicadorInterpretacion",
            "indicadorFrecuencia",
            "indicadorTipoPeriodo",
            "indicadorSentido",
            "indicadorDesagregacion",
            "indicadorAnioLB",
            "idDependencia",
            "observaciones",
            "status",
            "tipo",
            "valorAnioLB",
            "fecha_actualizacion",
            "proxima_actualizacion",
            "nivel",
            "en_revision",
            "fuente_informacion",
            "dependenciaNombre",
            "dependenciaSiglas",
            "numeroUR",
            "Objetivos",
            "Temas",
            "Sectores",
            "P2023",
            "M2023",
            "P2024",
            "P2025",
            "P2026",
            "P2027",
            "P2028",
            "Programas_P",
            "Objetivos_ODS"
        ];
    }
}
