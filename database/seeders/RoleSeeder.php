<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Es quien ejerce las funciones de Gerente. Aunque en ocasiones éstas las puede delegar en otra figura.
        $role1 = Role::create(['name' => 'Titular']);

        //En su rol está la adquisición, custodia y conservación de medicamentos y productos sanitarios, así como de las recetas dispensadas y de documentos sanitarios.
        $role2 = Role::create(['name' => 'Adjunto']);

        //Su función principal es apoyar al facultativo y mantener el material, el instrumental, los equipos y la zona de trabajo en óptimas condiciones para su utilización.
        $role3 = Role::create(['name' => 'Tecnico']);

        //Sus responsabilidades son recibir pedidos, manejar documentos, atender llamadas, organizar el espacio de trabajo y ayudar con el inventario.
        $role4 = Role::create(['name' => 'Auxiliar']);


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

    }
}
