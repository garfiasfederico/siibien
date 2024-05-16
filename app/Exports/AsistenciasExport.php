<?php

namespace App\Exports;

use App\Models\Asistencias;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class AsistenciasExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       return  Asistencias::select("tipo_enlace","nombre","dependenciaNombre","dependenciaSiglas","cargo","perfil","email","telefono",DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d %H:%i:%s')"),"evento")
                    ->join("dependencia","dependencia.idDependencia","=","asistencias.dependenciasId")
                    ->where("evento","itar")
                    ->get();
    }

    public function headings():array{

        //return array_keys($this->collection()->first()->toArray());
        return ["tipo enlace","nombre","dependencia","siglas","cargo","perfil","email","telefono","registro","evento"];
    }
}
