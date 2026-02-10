<?php

namespace Database\Factories;

use App\Models\Landlord;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'landlord_id' => Landlord::factory(),
            'room_number' => $this->faker->regexify('[A-B]{1}[1-9]{2}'),
            'floor' => $this->faker->randomElement(['1', '2', '3']),
            'base_price' => $this->faker->numberBetween(500000, 2000000),
            'room_type' => $this->faker->randomElement(['Putra', 'Putri', 'Campur']),
            'occupancy_status' => 'Tersedia',
            'active_occupants' => 0,
        ];
    }
}
