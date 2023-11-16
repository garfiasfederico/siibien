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
       return  Asistencias::select("nombre","dependenciaNombre","dependenciaSiglas","cargo","email","telefono",DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d %H:%i:%s')"))
                    ->join("dependencia","dependencia.idDependencia","=","asistencias.dependenciasId")->get();
    }

    public function headings():array{

        //return array_keys($this->collection()->first()->toArray());
        return ["nombre","dependencia","siglas","cargo","email","telefono","registro"];
    }
}
