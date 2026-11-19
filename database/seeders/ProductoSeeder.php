<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $catalogo = [
            ['sku' => 'LOG-G502',   'cat' => 'Periféricos',          'marca' => 'Logitech', 'nombre' => 'Mouse Gamer G502 Hero',              'modelo' => 'G502',        'garantia' => 12, 'regular' => 249.90, 'oferta' => 199.90, 'stock' => 20],
            ['sku' => 'LOG-MXM3S',  'cat' => 'Periféricos',          'marca' => 'Logitech', 'nombre' => 'Mouse Inalámbrico MX Master 3S',     'modelo' => 'MXM3S',       'garantia' => 12, 'regular' => 459.00, 'oferta' => null,   'stock' => 12],
            ['sku' => 'HYP-ALLOY',  'cat' => 'Periféricos',          'marca' => 'HyperX',   'nombre' => 'Teclado Mecánico Alloy Origins',     'modelo' => 'HX-KB6RDX',   'garantia' => 24, 'regular' => 389.00, 'oferta' => 329.00, 'stock' => 15],
            ['sku' => 'SNY-XM5',    'cat' => 'Audio y Sonido',       'marca' => 'Sony',     'nombre' => 'Audífonos WH-1000XM5 Noise Cancelling','modelo' => 'WH1000XM5', 'garantia' => 12, 'regular' => 1299.00,'oferta' => 1099.00,'stock' => 8],
            ['sku' => 'HYP-CLOUD3', 'cat' => 'Audio y Sonido',       'marca' => 'HyperX',   'nombre' => 'Headset Gamer Cloud III',            'modelo' => '727A8AA',     'garantia' => 24, 'regular' => 349.00, 'oferta' => null,   'stock' => 18],
            ['sku' => 'KNG-NV2-1T', 'cat' => 'Almacenamiento',       'marca' => 'Kingston', 'nombre' => 'SSD NVMe PCIe 4.0 NV2 1TB',          'modelo' => 'SNV2S/1000G', 'garantia' => 36, 'regular' => 269.00, 'oferta' => 229.00, 'stock' => 30],
            ['sku' => 'SAM-T7-1T',  'cat' => 'Almacenamiento',       'marca' => 'Samsung',  'nombre' => 'SSD Externo Portátil T7 1TB',        'modelo' => 'MU-PC1T0T',   'garantia' => 36, 'regular' => 420.00, 'oferta' => null,   'stock' => 10],
            ['sku' => 'ASU-VG249',  'cat' => 'Monitores',            'marca' => 'ASUS',     'nombre' => 'Monitor Gaming TUF 24" IPS 165Hz',   'modelo' => 'VG249Q1A',    'garantia' => 36, 'regular' => 799.00, 'oferta' => 699.00, 'stock' => 7],
            ['sku' => 'SAM-ODG3',   'cat' => 'Monitores',            'marca' => 'Samsung',  'nombre' => 'Monitor Odyssey G3 27" 144Hz',       'modelo' => 'LS27AG320',   'garantia' => 24, 'regular' => 899.00, 'oferta' => null,   'stock' => 9],
            ['sku' => 'TPL-AX55',   'cat' => 'Redes y Conectividad', 'marca' => 'TP-Link',  'nombre' => 'Router Wi-Fi 6 AX3000 Dual Band',    'modelo' => 'Archer AX55', 'garantia' => 24, 'regular' => 319.00, 'oferta' => 279.00, 'stock' => 14],
            ['sku' => 'COR-RM750E', 'cat' => 'Componentes PC',       'marca' => 'Corsair',  'nombre' => 'Fuente de Poder 750W 80+ Gold',      'modelo' => 'RM750e',      'garantia' => 60, 'regular' => 449.00, 'oferta' => null,   'stock' => 11],
            ['sku' => 'LOG-C920S',  'cat' => 'Accesorios Laptop',    'marca' => 'Logitech', 'nombre' => 'Webcam Full HD 1080p C920s Pro',     'modelo' => 'C920s',       'garantia' => 12, 'regular' => 299.00, 'oferta' => 249.00, 'stock' => 25],
        ];

        foreach ($catalogo as $item) {
            $categoria = Categoria::where('nombre', $item['cat'])->first();
            $marca     = Marca::where('nombre', $item['marca'])->first();

            Producto::updateOrCreate(
                ['sku' => $item['sku']],
                [
                    'categoria_id'     => $categoria->id,
                    'marca_id'         => $marca->id,
                    'nombre'           => $item['nombre'],
                    'modelo'           => $item['modelo'],
                    'descripcion'      => 'Producto original ' . $item['marca'] . ' modelo ' . $item['modelo'] . ' con garantía oficial.',
                    'especificaciones' => ['marca' => $item['marca'], 'modelo' => $item['modelo'], 'garantia_meses' => $item['garantia']],
                    'meses_garantia'   => $item['garantia'],
                    'precio_regular'   => $item['regular'],
                    'precio_oferta'    => $item['oferta'],
                    'inicio_oferta'    => $item['oferta'] ? now()->subDay() : null,
                    'fin_oferta'       => $item['oferta'] ? now()->addDays(15) : null,
                    'stock'            => $item['stock'],
                    'activo'           => true,
                ]
            );
        }
    }
}