<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AddAdministradorEventoRole extends Seeder
{
    public function run()
    {
        // Usamos firstOrCreate para evitar duplicados
        Role::firstOrCreate(['name' => 'administrador_evento']);
    }
}
