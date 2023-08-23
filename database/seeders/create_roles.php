<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class create_roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role = Role::create(['name'=>'enlace']);
        $role2 = Role::create(['name'=>'consulta']);
        $role3 = Role::create(['name'=>'administrador']);
    }
}
