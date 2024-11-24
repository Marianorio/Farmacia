<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            ['nombre' => 'Medicamento'],
            ['nombre' => 'Higiene Personal'],
            ['nombre' => 'Cuidado de Niños'],
            ['nombre' => 'Cosméticos'],
            ['nombre' => 'Perfumería'],
            ['nombre' => 'Cuidado Facial'],
            ['nombre' => 'Otros']
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}