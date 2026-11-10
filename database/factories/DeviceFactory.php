<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Device;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 */
class DeviceFactory extends Factory
{
    protected $model = Device::class;

    public function definition(): array
    {
        return [
            'nom' => fake()->randomElement([
                'PC ', 'Portable ', 'Ecran ', 'Imprimante ', 'Projecteur ',
            ]).fake()->unique()->bothify('??-###'),
            'marque' => fake()->randomElement(['Dell', 'HP', 'Lenovo', 'Asus', 'Apple', 'Samsung']),
            'numero_serie' => strtoupper(fake()->unique()->bothify('??-#####-?????')),
            'etat' => fake()->randomElement(['neuf', 'bon', 'en panne']),
            'date_achat' => fake()->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            'description' => fake()->optional()->sentence(8),
            'room_id' => Room::factory(),
        ];
    }

    public function enPanne(): static
    {
        return $this->state(fn () => ['etat' => 'en panne']);
    }

    public function neuf(): static
    {
        return $this->state(fn () => ['etat' => 'neuf']);
    }

    public function withCategories(int $count = 2): static
    {
        return $this->afterCreating(function (Device $device) use ($count) {
            $device->categories()->sync(Category::factory()->count($count)->create()->pluck('id'));
        });
    }
}
