<?php

namespace App\Exports;

use App\Models\Indicador;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IndicadoresExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
         return Indicador::select("idIndicador",
                                  "indicadorNombre",
                                  "indicadorObjetivo",
                                  "indicadorTipo",
                                  "indicadorDimension",
                                  "indicadorMetodo",
                                  "indicadorFormula",                                  
                                  "indicadorUM",
                                  "indicadorInterpretacion",
                                  "indicadorFrecuencia",
                                  "indicadorSentido",
                                  "dependencia.dependenciaSiglas as Responsable",
                                  "indicadorAnioLB",
                                  "valorAnioLB",
                                  "proxima_actualizacion",
                                  "nivel",
                                  "fuente_informacion",
                                  "en_revision"
                                )->leftjoin("dependencia","dependencia.idDependencia","=","indicador.idDependencia")->get();
    }
    public function headings():array{
        return array_keys($this->collection()->first()->toArray());
    }
}
