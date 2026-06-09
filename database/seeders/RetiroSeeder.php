<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RetiroSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('RETIRO')->insert([

            [
                'fecha_hora' => '2026-01-10 10:30:00',
                'id_usuario' => '21507579-6'
            ],

            [
                'fecha_hora' => '2026-02-15 13:20:00',
                'id_usuario' => '21507579-6'
            ],

            [
                'fecha_hora' => '2026-03-05 18:10:00',
                'id_usuario' => '21507579-6'
            ],

            [
                'fecha_hora' => '2026-04-12 12:00:00',
                'id_usuario' => '21507579-6'
            ],

            [
                'fecha_hora' => '2026-05-08 16:45:00',
                'id_usuario' => '21507579-6'
            ],

            [
                'fecha_hora' => '2026-06-20 20:15:00',
                'id_usuario' => '21507579-6'
            ]
        ]);
    }
}