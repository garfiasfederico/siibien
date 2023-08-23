<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Dependencia;

class DependenciasExport implements FromCollection, WithHeadings{

    public function collection()
    {
        return Dependencia::where("status",1)->get();
    }

    public function headings():array{
        return array_keys($this->collection()->first()->toArray());
    }
}


