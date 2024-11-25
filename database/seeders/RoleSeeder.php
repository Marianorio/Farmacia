<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles
        $rolTitular = Role::create(['name' => 'Titular']);
        $rolAdjunto = Role::create(['name' => 'Adjunto']);
        $rolTecnico = Role::create(['name' => 'Tecnico']);
        $rolAuxiliar = Role::create(['name' => 'Auxiliar']);

        // Crear permisos
        Permission::create(['name' => 'home']);
        Permission::create(['name' => 'perfil']);
        Permission::create(['name' => 'vista_admin']);
        Permission::create(['name' => 'productos']);
        Permission::create(['name' => 'recetas']);
        Permission::create(['name' => 'obras_sociales']);
        Permission::create(['name' => 'proveedores']);
        Permission::create(['name' => 'ventas']);
        Permission::create(['name' => 'roles']);
        Permission::create(['name' => 'reportes']);
        Permission::create(['name' => 'info']);

        // Asignar permisos al Titular (todos)
        $permisos = Permission::all();
        $rolTitular->syncPermissions($permisos);

        // Adjunto: todo excepto vista_admin y roles
        $rolAdjunto->givePermissionTo([
            'home', 'perfil', 'productos',
            'recetas', 'obras_sociales', 'proveedores', 
            'ventas', 'reportes', 'info'
        ]);

        // Técnico: acceso limitado
        $rolTecnico->givePermissionTo([
            'home', 'perfil', 'productos',
            'proveedores', 'ventas', 'info'
        ]);

        // Auxiliar: acceso muy limitado (ya no tiene acceso a productos)
        $rolAuxiliar->givePermissionTo([
            'home', 'perfil', 'ventas', 'info'
        ]);
    }
}
