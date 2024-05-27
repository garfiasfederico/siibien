<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class addRolesInforme extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name'=>'enlace_informe']);
        $role1 = Role::create(['name'=>'revisor_informe']);
        $role2 = Role::create(['name'=>'administrador_informe']);
        $role3 = Role::create(['name'=>'enlace_itar']);
        $role4 = Role::create(['name'=>'administrador_itar']);

    }
}
