<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PedidoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('PEDIDO')->insert([
            [
                'fecha' => '2025-12-28',
                'id_usuario' => '21507579-6'
            ],
            [
                'fecha' => '2026-01-25',
                'id_usuario' => '21507579-6'
            ],
            [
                'fecha' => '2026-02-27',
                'id_usuario' => '21507579-6'
            ],
            [
                'fecha' => '2026-03-29',
                'id_usuario' => '21507579-6'
            ],
            [
                'fecha' => '2026-04-28',
                'id_usuario' => '21507579-6'
            ],
            [
                'fecha' => '2026-05-30',
                'id_usuario' => '21507579-6'
            ]
        ]);
    }
}