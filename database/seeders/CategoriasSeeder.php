<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            [
                'nombre' => 'Medicamentos',
                'descripcion' => 'Productos farmacéuticos y medicinas de venta libre y con receta',
                'fecha_creacion' => now(),
                'fecha_actualizacion' => now(),
            ],
            [
                'nombre' => 'Higiene Personal',
                'descripcion' => 'Productos para el cuidado e higiene personal diaria',
                'fecha_creacion' => now(),
                'fecha_actualizacion' => now(),
            ],
            [
                'nombre' => 'Cuidado de Niños',
                'descripcion' => 'Productos especializados para el cuidado infantil',
                'fecha_creacion' => now(),
                'fecha_actualizacion' => now(),
            ],
            [
                'nombre' => 'Cosméticos',
                'descripcion' => 'Productos de maquillaje y belleza',
                'fecha_creacion' => now(),
                'fecha_actualizacion' => now(),
            ],
            [
                'nombre' => 'Perfumería',
                'descripcion' => 'Fragancias y perfumes para damas y caballeros',
                'fecha_creacion' => now(),
                'fecha_actualizacion' => now(),
            ],
            [
                'nombre' => 'Cuidado Facial',
                'descripcion' => 'Productos especializados para el cuidado de la piel del rostro',
                'fecha_creacion' => now(),
                'fecha_actualizacion' => now(),
            ],
            [
                'nombre' => 'Otros',
                'descripcion' => 'Productos varios que no encajan en otras categorías',
                'fecha_creacion' => now(),
                'fecha_actualizacion' => now(),
            ],
        ];

        DB::table('categorias')->insert($categorias);
    }
}
