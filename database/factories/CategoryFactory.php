<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'nom' => fake()->unique()->randomElement([
                'Ordinateur portable', 'Poste fixe', 'Ecran', 'Imprimante',
                'Projecteur', 'Serveur', 'Peripherique', 'Materiel reseau',
            ]).' '.$this->faker->unique()->numberBetween(1, 9999),
        ];
    }
}
