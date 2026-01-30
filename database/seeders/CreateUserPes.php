<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\EnlaceDependencia;
use Illuminate\Support\Facades\Hash;

class CreateUserPes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $enlace = new EnlaceDependencia();
        $enlace->titulo = "C.";
        $enlace->nombre = "Administrador";
        $enlace->apellidoP = "PES";
        $enlace->apellidoM = "Principal";
        $enlace->cargo = "Administrador PES";
        $enlace->tipoEnlace = "directivo";
        $enlace->email = "administrador.pes@gmail.com";
        $enlace->telefono = "951 50 15002";
        $enlace->teloficina = "951 50 15002";
        $enlace->idDependencia = 0;
        $enlace->save();

        $user = new User();
        $user->name = "Administrador PES";
        $user->cuenta = "SIIBIEN.PESADMIN";
        $user->password = Hash::make("p3sadm1n");
        $user->idEnlaceDependencia = $enlace->id;
        $user->ie = 0;
        $user->iarto = 0;
        $user->itar = 0;
        $user->save();

        $user->assignRole('administrador_pes');
    }
}
