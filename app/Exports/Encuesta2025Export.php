<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\EncuestaSiibien2025;
use Illuminate\Support\Facades\DB;

class Encuesta2025Export implements FromCollection, WithHeadings{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return EncuestaSiibien2025::select("id","p1","p2","p3","p4","p5",DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d %H:%i:%s') as registro") )->get();
    }

    public function headings():array{
        return array_keys($this->collection()->first()->toArray());
    }
}
