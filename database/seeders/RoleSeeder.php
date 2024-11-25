<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'Titular']);
        Role::create(['name' => 'Adjunto']);
        Role::create(['name' => 'Tecnico']);
        Role::create(['name' => 'Auxiliar']);
    }
}
