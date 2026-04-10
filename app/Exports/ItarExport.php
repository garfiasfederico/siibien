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
        return InformeAccion::select("id","nombre","descripcion", "objetivo",DB::raw("if(informe_acciones.prioritario=0,'no','si') as prioritario"),DB::raw("if(informe_acciones.vigente=0,'no','si') as vigente"),"ejePEDClave","ejePEDDescripcion","temaPEDClave","temaPEDDescripcion",DB::raw("CONCAT(sectores.claveSector,' ',sectores.sector) as sector"),"dependencia.dependenciaSiglas","informe_acciones.p_entrega",DB::raw("count(ia_bs.idBS) as bienes_servicios"),
                                DB::raw("(select GROUP_CONCAT(ia_bs.idBS SEPARATOR '|') from ia_bs where ia_bs.ia_id = informe_acciones.id) as BSids"))
                                ->join("dependencia","dependencia.idDependencia","=","informe_acciones.idDependencia")->orderBy("id")
                                ->leftjoin("ia_bs","ia_bs.ia_id","=","informe_acciones.id")
                                ->leftjoin("temaped","temaped.idTemaPED","=","informe_acciones.idTemaPED")
                                ->leftjoin("ejeped","ejeped.idEjePED","=","temaped.idEjePED")
                                ->leftJoin("ia_alineacion","ia_alineacion.ia_id","=","informe_acciones.id")
                                ->leftJoin("sectores","sectores.idSector","=","ia_alineacion.idSector")
                                ->groupBy("informe_acciones.id","informe_acciones.nombre","informe_acciones.descripcion","informe_acciones.objetivo","dependencia.dependenciaSiglas","informe_acciones.p_entrega","ejePEDClave","ejePEDDescripcion","temaPEDClave","temaPEDDescripcion","sectores.claveSector","sectores.sector","prioritario","vigente")
                                ->get();
    }

    public function headings():array{
        return array_keys($this->collection()->first()->toArray());
    }
}
