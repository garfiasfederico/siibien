<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateRegiones extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Region::create([
            "nombre" => "Sierra de Flores Magón"
        ]);
        Region::create([
            "nombre" => "Costa"
        ]);
        Region::create([
            "nombre" => "Istmo"
        ]);
        Region::create([
            "nombre" => "Mixteca"
        ]);
        Region::create([
            "nombre" => "Papaloapan"
        ]);
        Region::create([
            "nombre" => "Sierra de Juárez"
        ]);
        Region::create([
            "nombre" => "Sierra Sur"
        ]);
        Region::create([
            "nombre" => "Valles Centrales"
        ]);
    }
}
