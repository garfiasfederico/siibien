<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Titular;

class TitularesExport implements FromCollection, WithHeadings{

    public function collection()
    {
        return Titular::where("titulares.status",1)
        ->join("dependencia","dependencia.idDependencia","=","titulares.idDependencia")->orderBy("idTitular","DESC")->get();
    }

    public function headings():array{
        return array_keys($this->collection()->first()->toArray());
    }
}


