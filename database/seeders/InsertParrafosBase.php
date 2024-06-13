<?php

namespace Database\Seeders;

use App\Models\ParrafoBase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class InsertParrafosBase extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ParrafoBase::create([
            "cuerpo" => "Con el objetivo de &campo1, del &campo2 el Gobierno del Estado, a través de &campo3, mediante una inversión de &campo4, como parte del &campo5, proporcionó &campo6 en beneficio de &campo7, en &campo8, consolidando así el nuevo modelo de Gobierno.",
            "campos" =>"objetivo|periodo|dependencia|inversion|programa|bien|beneficiados|regiones"
        ]);

        ParrafoBase::create([
            "cuerpo" => "Como parte del &campo1, el Gobierno de la Primavera Oaxaqueña, a través de &campo2, con el propósito de &campo3, durante &campo4, con una inversión de &campo5, realizó &campo6, lo cual benefició a &campo7, en &campo8.",
            "campos" =>"programa|dependencia|objetivo|periodo|inversion|obra|beneficiados|regiones"
        ]);

        ParrafoBase::create([
            "cuerpo" => "Mediante una inversión de &campo1, por medio del &campo2, el Gobierno de la Transformación, a través de &campo3, a fin de &campo4, del &campo5, brindó &campo6, esta acción permitió beneficiar a &campo7, en &campo8. fortaleciendo nuevo modelo de Gobierno.",
            "campos" =>"inversion|programa|dependencia|objetivo|periodo|bien|beneficiados|regiones"
        ]);
    }
}
