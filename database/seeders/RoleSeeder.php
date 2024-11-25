<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Primero eliminamos los roles y permisos existentes
        Role::query()->delete();
        Permission::query()->delete();

        // Creamos los permisos
        $permissions = [
            'home',
            'perfil',
            'vista_admin',
            'productos',
            'recetas',
            'obras_sociales',
            'proveedores',
            'ventas',
            'roles',
            'reportes',
            'info'
        ];

        foreach($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Titular (acceso completo)
        $roleTitular = Role::create(['name' => 'Titular']);
        $roleTitular->givePermissionTo($permissions);
    }
}
