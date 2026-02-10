<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Landlord;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

test('tenant can only see their own rooms', function () {
    // Create two landlords
    $landlordA = Landlord::factory()->create(['name' => 'Landlord A']);
    $landlordB = Landlord::factory()->create(['name' => 'Landlord B']);

    // Create a user for Landlord A
    $userA = User::factory()->create(['landlord_id' => $landlordA->id]);

    // Create rooms for both landlords
    $roomA = Room::factory()->create(['landlord_id' => $landlordA->id, 'room_number' => '101']);
    $roomB = Room::factory()->create(['landlord_id' => $landlordB->id, 'room_number' => '102']);

    // Act as Landlord A
    actingAs($userA);

    // Assert that Landlord A can see their own room
    expect(Room::find($roomA->id))->not->toBeNull()
        ->and(Room::where('id', $roomA->id)->exists())->toBeTrue();

    // Assert that Landlord A CANNOT see Landlord B's room
    expect(Room::find($roomB->id))->toBeNull()
        ->and(Room::where('id', $roomB->id)->exists())->toBeFalse();
});

test('creating a room automatically assigns current landlord id', function () {
    $landlord = Landlord::factory()->create();
    $user = User::factory()->create(['landlord_id' => $landlord->id]);

    actingAs($user);

    $room = Room::create([
        'room_number' => '201',
        'base_price' => 1500000,
    ]);

    expect($room->landlord_id)->toBe($landlord->id);
});
