<?php

namespace Database\Factories;

use App\Models\Direccion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Direccion>
 */
class DireccionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'       => User::factory(),
            'calle'         => fake()->streetAddress(),
            'ciudad'        => fake()->randomElement(['Cusco', 'Lima', 'Arequipa', 'Trujillo']),
            'referencia'    => 'Cerca a ' . fake()->streetName(),
            'codigo_postal' => fake()->numerify('08###'),
            'es_principal'  => false,
        ];
    }
}
