<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CategoriasSeeder;
use Database\Seeders\ObrasSocialesSeeder;
use Database\Seeders\ProductosSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategoriasSeeder::class,
            ObrasSocialesSeeder::class,
            ProductosSeeder::class,
        ]);
    }
}
