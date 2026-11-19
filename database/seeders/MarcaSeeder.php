<?php

namespace Database\Seeders;

use App\Models\Marca;
use Illuminate\Database\Seeder;

class MarcaSeeder extends Seeder
{
    public function run(): void
    {
        $marcas = [
            'Logitech',
            'Sony',
            'Kingston',
            'ASUS',
            'TP-Link',
            'Corsair',
            'Samsung',
            'HyperX',
        ];

        foreach ($marcas as $nombre) {
            Marca::firstOrCreate(['nombre' => $nombre], ['activo' => true]);
        }
    }
}