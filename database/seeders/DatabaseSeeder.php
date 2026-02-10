<?php

namespace Database\Seeders;

use App\Models\Landlord;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Super Admin (Viewing All Landlords)
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@ardakos.com',
            'password' => Hash::make('password'),
            'landlord_id' => null, // Super Admin
        ]);

        // 2. Create Landlord A (Arda Kost Putra)
        $landlordA = Landlord::factory()->create([
            'name' => 'Arda Kost Putra',
            'email' => 'putra@ardakos.com',
        ]);

        User::factory()->create([
            'name' => 'Admin Putra',
            'email' => 'admin.putra@ardakos.com',
            'password' => Hash::make('password'),
            'landlord_id' => $landlordA->id,
        ]);

        // Create 10 Rooms for Landlord A
        $roomsA = Room::factory(10)
            ->sequence(fn ($sequence) => ['room_number' => 'A' . ($sequence->index + 1)])
            ->create([
                'landlord_id' => $landlordA->id,
                'room_type' => 'Putra',
                'occupancy_status' => 'Tersedia',
            ]);

        // Assign Tenants to first 5 rooms
        foreach ($roomsA->take(5) as $room) {
            Tenant::factory()->create([
                'landlord_id' => $landlordA->id,
                'room_id' => $room->id,
                'gender' => 'Laki-laki',
                'name' => fake()->name('male'),
            ]);
            $room->update(['occupancy_status' => 'Terisi', 'active_occupants' => 1]);
        }


        // 3. Create Landlord B (Arda Kost Putri)
        $landlordB = Landlord::factory()->create([
            'name' => 'Arda Kost Putri',
            'email' => 'putri@ardakos.com',
        ]);

        User::factory()->create([
            'name' => 'Admin Putri',
            'email' => 'admin.putri@ardakos.com',
            'password' => Hash::make('password'),
            'landlord_id' => $landlordB->id,
        ]);

        // Create 10 Rooms for Landlord B
        $roomsB = Room::factory(10)
            ->sequence(fn ($sequence) => ['room_number' => 'B' . ($sequence->index + 1)])
            ->create([
                'landlord_id' => $landlordB->id,
                'room_type' => 'Putri',
                'occupancy_status' => 'Tersedia',
            ]);

        // Assign Tenants to first 8 rooms
        foreach ($roomsB->take(8) as $room) {
            Tenant::factory()->create([
                'landlord_id' => $landlordB->id,
                'room_id' => $room->id,
                'gender' => 'Perempuan',
                'name' => fake()->name('female'),
            ]);
            $room->update(['occupancy_status' => 'Terisi', 'active_occupants' => 1]);
        }
    }
}
