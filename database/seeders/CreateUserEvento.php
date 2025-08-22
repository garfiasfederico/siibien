<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\EnlaceDependencia;
use Illuminate\Support\Facades\Hash;

class CreateUserEvento extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $enlace = new EnlaceDependencia();
        $enlace->titulo = "C.";
        $enlace->nombre = "Administrador";
        $enlace->apellidoP = "de Eventos";
        $enlace->apellidoM = "Principal";
        $enlace->cargo = "Administrador de Evento";
        $enlace->tipoEnlace = "directivo";
        $enlace->email = "administrador.evento@gmail.com";
        $enlace->telefono = "951 50 15001";
        $enlace->teloficina = "951 50 15001";
        $enlace->idDependencia = 0;
        $enlace->save();

        $user = new User();
        $user->name = "Administrador Evento";
        $user->cuenta = "SIIBIEN.EVENTOADMIN";
        $user->password = Hash::make("3v3nt0adm1n"); 
        $user->idEnlaceDependencia = $enlace->id;
        $user->ie = 0;
        $user->iarto = 0;
        $user->itar = 0;
        $user->save();

        $user->assignRole('administrador_evento');
    }
}
