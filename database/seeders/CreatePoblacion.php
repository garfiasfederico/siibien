<?php

namespace Database\Seeders;

use App\Models\Poblacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreatePoblacion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Poblacion::create(["descripcion"=>"Adolescentes"]);
        Poblacion::create(["descripcion"=>"Adultos(as)"]);
        Poblacion::create(["descripcion"=>"Adultos(as) Mayores"]);
        Poblacion::create(["descripcion"=>"Alumnos(as)"]);
        Poblacion::create(["descripcion"=>"Artesanos(as)"]);
        Poblacion::create(["descripcion"=>"Defraudados(as) por caja de ahorro"]);
        Poblacion::create(["descripcion"=>"Docentes"]);
        Poblacion::create(["descripcion"=>"Elementos policiales"]);
        Poblacion::create(["descripcion"=>"Familias"]);
        Poblacion::create(["descripcion"=>"Indígenas y/o afromexicanos"]);
        Poblacion::create(["descripcion"=>"Jóvenes"]);
        Poblacion::create(["descripcion"=>"Madres solteras"]);
        Poblacion::create(["descripcion"=>"Migrantes"]);
        Poblacion::create(["descripcion"=>"Mujeres"]);
        Poblacion::create(["descripcion"=>"Niños(as)"]);
        Poblacion::create(["descripcion"=>"Otros(as)"]);
        Poblacion::create(["descripcion"=>"Personas con discapacidad"]);
        Poblacion::create(["descripcion"=>"Pescadores(as)"]);
        Poblacion::create(["descripcion"=>"Población en general"]);
        Poblacion::create(["descripcion"=>"Productores(as)"]);
        Poblacion::create(["descripcion"=>"Servidores(as) públicos(as)"]);
    }
}
