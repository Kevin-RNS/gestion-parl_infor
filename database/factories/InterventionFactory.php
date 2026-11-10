<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\Intervention;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Intervention>
 */
class InterventionFactory extends Factory
{
    protected $model = Intervention::class;

    public function definition(): array
    {
        return [
            'date' => fake()->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'type' => fake()->randomElement(['maintenance', 'panne', 'reparation']),
            'commentaire' => fake()->optional()->sentence(10),
            'device_id' => Device::factory(),
        ];
    }
}
