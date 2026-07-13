<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetallePedidoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('DETALLE_PEDIDO')->insert([

            // Pedido 1
            [
                'id_pedido' => 1,
                'id_producto' => 1,
                'cantidad' => 100,
                'costo' => 1200,
                'fecha_vencimiento' => '2026-12-31'
            ],
            [
                'id_pedido' => 1,
                'id_producto' => 5,
                'cantidad' => 200,
                'costo' => 200,
                'fecha_vencimiento' => '2026-06-30'
            ],

            // Pedido 2
            [
                'id_pedido' => 2,
                'id_producto' => 2,
                'cantidad' => 60,
                'costo' => 800,
                'fecha_vencimiento' => '2026-08-15'
            ],
            [
                'id_pedido' => 2,
                'id_producto' => 4,
                'cantidad' => 40,
                'costo' => 6500,
                'fecha_vencimiento' => '2026-07-20'
            ],

            // Pedido 3
            [
                'id_pedido' => 3,
                'id_producto' => 3,
                'cantidad' => 80,
                'costo' => 1500,
                'fecha_vencimiento' => '2027-01-01'
            ],
            [
                'id_pedido' => 3,
                'id_producto' => 1,
                'cantidad' => 50,
                'costo' => 1200,
                'fecha_vencimiento' => '2026-12-31'
            ],

            // Pedido 4
            [
                'id_pedido' => 4,
                'id_producto' => 5,
                'cantidad' => 150,
                'costo' => 200,
                'fecha_vencimiento' => '2026-06-30'
            ],
            [
                'id_pedido' => 4,
                'id_producto' => 2,
                'cantidad' => 40,
                'costo' => 800,
                'fecha_vencimiento' => '2026-08-15'
            ],

            // Pedido 5
            [
                'id_pedido' => 5,
                'id_producto' => 4,
                'cantidad' => 35,
                'costo' => 6500,
                'fecha_vencimiento' => '2026-07-20'
            ],
            [
                'id_pedido' => 5,
                'id_producto' => 3,
                'cantidad' => 70,
                'costo' => 1500,
                'fecha_vencimiento' => '2027-01-01'
            ],

            // Pedido 6
            [
                'id_pedido' => 6,
                'id_producto' => 1,
                'cantidad' => 80,
                'costo' => 1200,
                'fecha_vencimiento' => '2026-12-31'
            ],
            [
                'id_pedido' => 6,
                'id_producto' => 3,
                'cantidad' => 60,
                'costo' => 1500,
                'fecha_vencimiento' => '2027-01-01'
            ]
        ]);
    }
}