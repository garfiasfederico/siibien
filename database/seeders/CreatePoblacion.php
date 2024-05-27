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
        Poblacion::create(["descripcion"=>"Adolescente"]);
        Poblacion::create(["descripcion"=>"Adulto(a)"]);
        Poblacion::create(["descripcion"=>"Adulto(a) Mayor"]);
        Poblacion::create(["descripcion"=>"Alumno(a)"]);
        Poblacion::create(["descripcion"=>"Artesano(a)"]);
        Poblacion::create(["descripcion"=>"Defraudado(a) por caja de ahorro"]);
        Poblacion::create(["descripcion"=>"Docente"]);
        Poblacion::create(["descripcion"=>"Elemento policial"]);
        Poblacion::create(["descripcion"=>"Familia"]);
        Poblacion::create(["descripcion"=>"Indígena y/o afromexicano"]);
        Poblacion::create(["descripcion"=>"Joven"]);
        Poblacion::create(["descripcion"=>"Madre soltera"]);
        Poblacion::create(["descripcion"=>"Migrante"]);
        Poblacion::create(["descripcion"=>"Mujer"]);
        Poblacion::create(["descripcion"=>"Niño(a)"]);
        Poblacion::create(["descripcion"=>"Otro(a)"]);
        Poblacion::create(["descripcion"=>"Persona con discapacidad"]);
        Poblacion::create(["descripcion"=>"Pescador(a)"]);
        Poblacion::create(["descripcion"=>"Población en general"]);
        Poblacion::create(["descripcion"=>"Productor(a)"]);
        Poblacion::create(["descripcion"=>"Servidor(a) pública"]);
    }
}
