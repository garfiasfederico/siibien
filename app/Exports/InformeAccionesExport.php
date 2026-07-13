<?php

namespace App\Exports;

use App\Models\InformeAccion;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class InformeAccionesExport implements FromCollection, WithHeadings
{
    protected $consulta;

    function __construct($consulta=0)
    {
        $this->consulta = $consulta;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        /*return InformeAccion::select("informe_acciones.id","informe_acciones.nombre","dependenciaSiglas",DB::raw("CONCAT(temaped.temaPEDClave,' ',temaped.temaPEDDescripcion) as tema"),"parrafos_max","creacion","(select count(*) as 'parrafos_R' from informe_parrafos where informe_acciones.id = informe_parrafos.acciones_id group by informe_acciones.id)")
        ->join("dependencia","dependencia.idDependencia","=","informe_acciones.idDependencia")
        ->join("temaped","temaped.idTemaPED","=","informe_acciones.idTemaPED")
        ->orderBy("informe_acciones.id","ASC")->get();*/
        if($this->consulta==0){
            $detallado = DB::select("select informe_acciones.id, informe_acciones.nombre, dependenciaSiglas, CONCAT(temaped.temaPEDClave,' ',temaped.temaPEDDescripcion) as 'tema',parrafos_max,creacion, informe_acciones.status as 'activa',
                                (select count(*) as 'parrafos_R' from informe_parrafos where informe_acciones.id = informe_parrafos.informe_acciones_id group by informe_acciones.id) as 'parrafos', if(reporta4to=0,'No','Si'),IF(justificacion4to is NULL OR justificacion4to='' ,'',IF(justificacion4to='no_4to_trim','No cuenta con información del 4to trimestre 2025','Se reportará en otro PPA'))
                                from informe_acciones
                                inner join dependencia on dependencia.idDependencia = informe_acciones.idDependencia
                                inner join temaped on temaped.idTemaPED = informe_acciones.idTemaPED
                                order by informe_acciones.id asc");
        }else{
            $detallado = DB::select("select informe_acciones.id, informe_acciones.nombre, dependenciaSiglas, CONCAT(temaped.temaPEDClave,' ',temaped.temaPEDDescripcion) as 'tema' 
                                from informe_acciones
                                inner join dependencia on dependencia.idDependencia = informe_acciones.idDependencia
                                inner join temaped on temaped.idTemaPED = informe_acciones.idTemaPED
                                order by informe_acciones.id asc");
        }        
        return (collect($detallado));
    }

    public function headings():array{
        if($this->consulta==0){
            return [
                "idPPA",
                "Descripción",
                "Responsable",
                "Tema",
                "Max Párrafos",
                "Creación",
                "Activa",
                "Párrafos Redactados",
                "Reporta 4to Informe",
                "Justificación"
            ];
        }else{
            return [
                "idPPA",
                "Descripción",
                "Responsable",
                "Tema"              
            ];
        }
        
    }
}
