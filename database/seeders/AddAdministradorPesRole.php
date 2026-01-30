<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AddAdministradorPesRole extends Seeder
{
    public function run()
    {
        Role::firstOrCreate(['name' => 'administrador_pes']);
    }
}
