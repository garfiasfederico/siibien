<?php

namespace App\Exports;

use App\Models\InformeAccion;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class InformeAccionesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return InformeAccion::select("informe_acciones.id","informe_acciones.nombre","dependenciaSiglas",DB::raw("CONCAT(temaped.temaPEDClave,' ',temaped.temaPEDDescripcion) as tema"),"parrafos_max","creacion")
        ->join("dependencia","dependencia.idDependencia","=","informe_acciones.idDependencia")
        ->join("temaped","temaped.idTemaPED","=","informe_acciones.idTemaPED")
        ->orderBy("informe_acciones.id","ASC")->get();
    }

    public function headings():array{
        return array_keys($this->collection()->first()->toArray());
    }
}
