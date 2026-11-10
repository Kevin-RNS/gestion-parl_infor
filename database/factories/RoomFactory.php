<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'nom' => 'Salle '.fake()->unique()->numberBetween(1, 999),
            'batiment' => fake()->randomElement(['A', 'B', 'C', 'Batiment Nord', 'Annexe']),
            'capacite' => fake()->numberBetween(4, 60),
        ];
    }
}
