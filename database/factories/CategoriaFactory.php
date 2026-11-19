<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Categoria>
 */
class CategoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->unique()->randomElement([
                'Periféricos', 'Audio y Sonido', 'Almacenamiento',
                'Monitores', 'Redes y Conectividad', 'Componentes PC',
                'Accesorios Laptop', 'Cables y Adaptadores',
            ]),
            'activo' => true,
        ];
    }
}
