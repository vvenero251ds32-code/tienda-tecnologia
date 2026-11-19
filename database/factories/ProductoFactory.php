<?php

namespace Database\Factories;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Marca;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $regular = fake()->randomFloat(2, 45, 1200);

        return [
            'categoria_id'     => Categoria::factory(),
            'marca_id'         => Marca::factory(),
            'sku'              => strtoupper(fake()->unique()->bothify('TEC-###??')),
            'nombre'           => fake()->randomElement([
                'Mouse Inalámbrico Pro', 'Teclado Mecánico RGB',
                'Audífonos Over-Ear ANC', 'SSD NVMe 1TB Gen4',
                'Router Wi-Fi 6 Dual Band', 'Monitor IPS 24" 144Hz',
            ]) . ' ' . fake()->bothify('??-##'),
            'modelo'           => strtoupper(fake()->bothify('MOD-###?')),
            'descripcion'      => fake()->sentence(12),
            'especificaciones' => [
                'conectividad' => fake()->randomElement(['USB-C', 'Bluetooth 5.3', 'Inalámbrico 2.4GHz']),
                'color'        => fake()->randomElement(['Negro', 'Blanco', 'Gris Espacial']),
            ],
            'meses_garantia'   => fake()->randomElement([6, 12, 24]),
            'precio_regular'   => $regular,
            'precio_oferta'    => null,
            'inicio_oferta'    => null,
            'fin_oferta'       => null,
            'stock'            => fake()->numberBetween(5, 40),
            'activo'           => true,
        ];
    }

    public function enOferta(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'precio_oferta' => round($attributes['precio_regular'] * 0.80, 2),
                'inicio_oferta' => now()->subDay(),
                'fin_oferta'    => now()->addDays(7),
            ];
        });
    }
}
