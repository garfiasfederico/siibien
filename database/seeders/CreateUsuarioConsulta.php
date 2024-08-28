<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\EnlaceDependencia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateUsuarioConsulta extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usuario = new EnlaceDependencia();
        $usuario->titulo = "C.";
        $usuario->nombre = "Usuario";
        $usuario->apellidoP = "de Consulta";
        $usuario->apellidoM = "APE";
        $usuario->cargo = "Consulta";
        $usuario->tipoEnlace = "directivo";
        $usuario->email = "siibien.consultaa@gmail.com";
        $usuario->telefono = "951 50 15000";
        $usuario->teloficina = "951 50 15000";
        $usuario->idDependencia = 0;
        if($usuario->save()){

            $user = new User();
            $user->name = "Usuario de Consulta APE";
            $user->cuenta = "SIIBIEN.CONSULTA";
            $user->password = Hash::make("Uc0n5ult4");
            $user->idEnlaceDependencia = $usuario->id;
            $user->ie = 0;
            $user->iarto = 0;
            $user->informe = 0;
            $user->save();
            $user->assignRole('consulta');
        }
    }
}
