<?php

namespace App\Exports;

use App\Models\PPA;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PPAsExport implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PPA::select("*")->get();
    }

    public function headings():array{
        return array_keys($this->collection()->first()->toArray());
    }
}
