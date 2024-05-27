<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\EnlaceDependencia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateUserAdministradorInforme extends Seeder
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
        $usuario->apellidoP = "Informe";
        $usuario->apellidoM = "Gobierno";
        $usuario->cargo = "Administrador";
        $usuario->tipoEnlace = "directivo";
        $usuario->email = "informes.gobieno.oaxaca@gmail.com";
        $usuario->telefono = "951 50 15000";
        $usuario->teloficina = "951 50 15000";
        $usuario->idDependencia = 0;
        if($usuario->save()){

            $user = new User();
            $user->name = "Administración Informe de Gobierno";
            $user->cuenta = "SIIBIEN.INFORMEADMIN";
            $user->password = Hash::make("1nf0rm34dm1n");
            $user->idEnlaceDependencia = $usuario->id;
            $user->ie = 0;
            $user->iarto = 1;
            $user->save();
            $user->assignRole('administrador_informe');
        }
    }
}
