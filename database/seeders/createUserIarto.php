<?php

namespace Database\Seeders;

use App\Models\EnlaceDependencia;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class createUserIarto extends Seeder
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
        $usuario->nombre = "Administración";
        $usuario->apellidoP = "Pública";
        $usuario->apellidoM = "Estatal";
        $usuario->cargo = "Asesor";
        $usuario->tipoEnlace = "operativo";
        $usuario->email = "informes.gobieno.oaxaca@gmail.com";
        $usuario->telefono = "951 50 15000";
        $usuario->teloficina = "951 50 15000";
        $usuario->idDependencia = 0;
        if($usuario->save()){

            $user = new User();
            $user->name = "Administración Pública Estatal";
            $user->cuenta = "SIIBIEN.IARTO";
            $user->password = Hash::make("14rt02024");
            $user->idEnlaceDependencia = $usuario->id;
            $user->ie = 0;
            $user->iarto = 1;
            $user->save();
            $user->assignRole('administrador');
        }
    }
}
