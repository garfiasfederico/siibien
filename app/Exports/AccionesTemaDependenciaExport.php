<?php

namespace App\Exports;

use App\Models\InformeAccion;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class AccionesTemaDependenciaExport implements FromCollection,  WithHeadings

{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $tema;

    function __construct($tema)
    {
        $this->tema = $tema;
    }

    public function collection()
    {
        return InformeAccion::select("informe_acciones.id","informe_acciones.nombre","idTemaPED")->where("informe_acciones.idDependencia", auth()->user()->enlace->idDependencia)
        ->where("idTemaPED", $this->tema)
        ->join("dependencia", "dependencia.idDependencia", "=", "informe_acciones.idDependencia")
        ->get();
    }
    public function headings():array{
        return array_keys($this->collection()->first()->toArray());
    }
}
