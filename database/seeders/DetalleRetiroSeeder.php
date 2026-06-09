<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetalleRetiroSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('DETALLE_RETIRO')->insert([

            // Enero
            [
                'id_retiro' => 1,
                'id_producto' => 1,
                'cantidad' => 20
            ],
            [
                'id_retiro' => 1,
                'id_producto' => 3,
                'cantidad' => 10
            ],

            // Febrero
            [
                'id_retiro' => 2,
                'id_producto' => 2,
                'cantidad' => 15
            ],
            [
                'id_retiro' => 2,
                'id_producto' => 4,
                'cantidad' => 5
            ],

            // Marzo
            [
                'id_retiro' => 3,
                'id_producto' => 1,
                'cantidad' => 30
            ],
            [
                'id_retiro' => 3,
                'id_producto' => 5,
                'cantidad' => 50
            ],

            // Abril
            [
                'id_retiro' => 4,
                'id_producto' => 3,
                'cantidad' => 25
            ],

            // Mayo
            [
                'id_retiro' => 5,
                'id_producto' => 4,
                'cantidad' => 12
            ],

            // Junio
            [
                'id_retiro' => 6,
                'id_producto' => 1,
                'cantidad' => 40
            ],
            [
                'id_retiro' => 6,
                'id_producto' => 3,
                'cantidad' => 35
            ]
        ]);
    }
}