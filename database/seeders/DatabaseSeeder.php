<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Device;
use App\Models\Intervention;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@techstock.local'],
            ['name' => 'Admin', 'password' => bcrypt('password')],
        );

        $rooms = Room::factory()->count(6)->create();

        $categories = collect([
            'Ordinateur portable', 'Poste fixe', 'Ecran', 'Imprimante',
            'Projecteur', 'Serveur', 'Matériel réseau',
        ])->map(fn (string $nom) => Category::create(['nom' => $nom]));

        $devices = Device::factory()->count(28)->create([
            'room_id' => fn () => $rooms->random()->id,
        ]);

        $devices->each(function (Device $device) use ($categories) {
            $device->categories()->sync($categories->random(fake()->numberBetween(1, 3))->pluck('id'));
        });

        Intervention::factory()->count(45)->create([
            'device_id' => fn () => $devices->random()->id,
        ]);
    }
}
