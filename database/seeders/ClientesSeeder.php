<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientesSeeder extends Seeder
{
   public function run()
   {
       $clientes = [
           [
               'nombre' => 'Juan Pérez',
               'dni' => '25456789',
               'fecha_creacion' => now()
           ],
           [
               'nombre' => 'María González',
               'dni' => '30789456',
               'fecha_creacion' => now()
           ],
           [
               'nombre' => 'Carlos Rodríguez',
               'dni' => '28567891',
               'fecha_creacion' => now()
           ],
           [
               'nombre' => 'Ana Martínez',
               'dni' => '33456123',
               'fecha_creacion' => now()
           ],
           [
               'nombre' => 'Luis García',
               'dni' => '27891234',
               'fecha_creacion' => now()
           ]
       ];
        DB::table('clientes')->insert($clientes);
   }
}
