<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence(5),
            'descripcion' => $this->faker->sentence(20),
            'imagen' => $this->faker->uuid() . '.jpg',
            'user_id' => $this->faker->randomElement([1, 2, 3, 4, 5]) // Asigna de forma aleatoria los elementos del arreglo
        ];
    }
}

// Tinker es un CLI ya integrado en Laravel con el que puedes interactuar con tu app y base de datos
// El comando para correr un factory es "sail artisan tinker"
