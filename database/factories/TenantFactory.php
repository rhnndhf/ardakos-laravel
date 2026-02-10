<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    public function definition(): array
    {
        return [
            'landlord_id' => function (array $attributes) {
                return Room::find($attributes['room_id'])->landlord_id;
            },
            'room_id' => Room::factory(),
            'name' => $this->faker->name(),
            'gender' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'status' => 'AKTIF',
            'phone' => $this->faker->phoneNumber(),
            'ktp_url' => $this->faker->imageUrl(),
            'check_in_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'check_out_date' => null,
        ];
    }
}
