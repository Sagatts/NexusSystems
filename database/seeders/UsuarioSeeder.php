<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('USUARIO')->insert([
            [
                'rut' => '21507579-6',
                'nombre' => 'Fernando Arriagada',
                'email' => 'fernando.arriagada.22@alumnos.uda.cl',
                'contrasena' => Hash::make('12345678'),
                'rol' => 'administrador',
                'remember_token' => null
            ],
            [
                'rut' => '10005810-3',
                'nombre' => 'Hector',
                'email' => 'Hector@ejemplo.cl',
                'contrasena' => Hash::make('12345678'),
                'rol' => 'cocina',
                'remember_token' => null
            ]
        ]);
    }
}