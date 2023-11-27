<?php

namespace App\Exports;

use App\Models\EncuestaSiibien;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EncuestasExport implements FromCollection, WithHeadings{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return EncuestaSiibien::all();
    }

    public function headings():array{
        return array_keys($this->collection()->first()->toArray());
    }
}
