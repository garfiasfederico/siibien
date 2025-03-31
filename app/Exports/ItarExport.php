<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\InformeAccion;
use Illuminate\Support\Facades\DB;

class ItarExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        return InformeAccion::select("id","nombre","descripcion", "objetivo","ejePEDClave","ejePEDDescripcion","temaPEDClave","temaPEDDescripcion","dependencia.dependenciaSiglas","informe_acciones.p_entrega",DB::raw("count(ia_bs.idBS) as bienes_servicios"))
                                ->join("dependencia","dependencia.idDependencia","=","informe_acciones.idDependencia")->orderBy("id")
                                ->leftjoin("ia_bs","ia_bs.ia_id","=","informe_acciones.id")
                                ->leftjoin("temaped","temaped.idTemaPED","=","informe_acciones.idTemaPED")
                                ->leftjoin("ejeped","ejeped.idEjePED","=","temaped.idEjePED")
                                ->groupBy("informe_acciones.id","informe_acciones.nombre","informe_acciones.descripcion","informe_acciones.objetivo","dependencia.dependenciaSiglas","informe_acciones.p_entrega","ejePEDClave","ejePEDDescripcion","temaPEDClave","temaPEDDescripcion")
                                ->get();
    }

    public function headings():array{
        return array_keys($this->collection()->first()->toArray());
    }
}
