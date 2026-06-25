<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        Producto::insert([
            [
                'codigo_barras' => '780000001',
                'nombre' => 'Vienesa',
                'precio_neto' => 1200,
                'stock' => 100,
                'fecha_vencimiento' => '2026-12-31',
                'id_categoria' => 3
            ],
            [
                'codigo_barras' => '780000002',
                'nombre' => 'Tomate',
                'precio_neto' => 800,
                'stock' => 50,
                'fecha_vencimiento' => '2026-08-15',
                'id_categoria' => 4
            ],
            [
                'codigo_barras' => '780000003',
                'nombre' => 'Bebida Coca-Cola 350cc',
                'precio_neto' => 1500,
                'stock' => 80,
                'fecha_vencimiento' => '2027-01-01',
                'id_categoria' => 7
            ],
            [
                'codigo_barras' => '780000004',
                'nombre' => 'Carne Vacuno',
                'precio_neto' => 6500,
                'stock' => 40,
                'fecha_vencimiento' => '2026-07-20',
                'id_categoria' => 2
            ],
            [
                'codigo_barras' => '780000005',
                'nombre' => 'Pan Completo',
                'precio_neto' => 200,
                'stock' => 200,
                'fecha_vencimiento' => '2026-06-30',
                'id_categoria' => 11
            ]
        ]);
    }
}