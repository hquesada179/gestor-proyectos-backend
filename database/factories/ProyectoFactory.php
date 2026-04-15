<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Proyecto>
 */
class ProyectoFactory extends Factory
{
    public function definition(): array
    {
        $fechaInicio = fake()->dateTimeBetween('-6 months', '-1 month');
        $fechaFin    = fake()->dateTimeBetween($fechaInicio, '+4 months');

        return [
            'user_id'            => User::factory(),
            'nombre'             => fake()->sentence(3, false),
            'descripcion'        => fake()->paragraph(2),
            'estado'             => fake()->randomElement(['activo', 'pausado', 'completado', 'cancelado']),
            'fecha_inicio'       => $fechaInicio->format('Y-m-d'),
            'fecha_fin_estimada' => $fechaFin->format('Y-m-d'),
        ];
    }

    public function activo(): static
    {
        return $this->state(['estado' => 'activo']);
    }

    public function completado(): static
    {
        return $this->state(['estado' => 'completado']);
    }
}
