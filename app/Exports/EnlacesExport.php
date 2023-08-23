<?php

namespace App\Exports;

use App\Models\EnlaceDependencia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EnlacesExport implements FromCollection, WithHeadings{

    public function collection()
    {
        return EnlaceDependencia::where("enlacedependencia.status", 1)
        ->join("dependencia", "enlacedependencia.idDependencia", "=", "dependencia.idDependencia")
        ->join("users", "users.idEnlaceDependencia", "=", "enlacedependencia.idEnlaceDependencia")
        ->select('enlacedependencia.*', 'dependencia.*', 'users.*', 'users.status as statusUser')
        ->get();
    }

    public function headings():array{
        return array_keys($this->collection()->first()->toArray());
    }
}


