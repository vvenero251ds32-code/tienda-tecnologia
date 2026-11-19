<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Periféricos',
            'Audio y Sonido',
            'Almacenamiento',
            'Monitores',
            'Redes y Conectividad',
            'Componentes PC',
            'Accesorios Laptop',
            'Cables y Adaptadores',
        ];

        foreach ($categorias as $nombre) {
            Categoria::firstOrCreate(['nombre' => $nombre], ['activo' => true]);
        }
    }
}