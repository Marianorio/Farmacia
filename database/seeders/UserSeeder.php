<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario Titular
        User::create([
            'name' => 'Titular',
            'email' => 'titular@ejemplo.com',
            'password' => Hash::make('password')
        ])->assignRole('Titular');

        // Usuario Adjunto
        User::create([
            'name' => 'Adjunto',
            'email' => 'adjunto@ejemplo.com',
            'password' => Hash::make('password')
        ])->assignRole('Adjunto');

        // Usuario Técnico
        User::create([
            'name' => 'Tecnico',
            'email' => 'tecnico@ejemplo.com',
            'password' => Hash::make('password')
        ])->assignRole('Tecnico');

        // Usuario Auxiliar
        User::create([
            'name' => 'Auxiliar',
            'email' => 'auxiliar@ejemplo.com',
            'password' => Hash::make('password')
        ])->assignRole('Auxiliar');
    }
}