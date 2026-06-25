<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Sin Categoria',
            'Carnes',
            'Embutidos',
            'Verduras',
            'Frutas',
            'Lácteos',
            'Bebidas',
            'Abarrotes',
            'Condimentos',
            'Congelados',
            'Panadería',
            'Mariscos',
            'Pollo',
            'Aceites',
            'Salsas',
            'Postres'
        ];

        foreach ($categorias as $categoria) {
            Categoria::create([
                'nombre' => $categoria
            ]);
        }
    }
}