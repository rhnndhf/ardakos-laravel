<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Landlord;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\User;
use App\Services\TenantService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

use function Pest\Laravel\actingAs;

uses(TestCase::class, RefreshDatabase::class);

test('registerTenant successfully registers a tenant', function () {
    $landlord = Landlord::factory()->create();
    $user = User::factory()->create(['landlord_id' => $landlord->id]);
    $room = Room::factory()->create([
        'landlord_id' => $landlord->id,
        'room_type' => 'Putra',
        'occupancy_status' => 'Tersedia',
        'active_occupants' => 0,
    ]);

    actingAs($user);

    $service = new TenantService();
    $data = [
        'name' => 'John Doe',
        'gender' => 'Laki-laki',
        'phone' => '08123456789',
        'ktp_url' => 'https://example.com/ktp.jpg',
        'check_in_date' => '2026-01-01',
        'room_id' => $room->id,
    ];

    $tenant = $service->registerTenant($data);

    expect($tenant)->toBeInstanceOf(Tenant::class)
        ->name->toBe('John Doe')
        ->status->toBe('AKTIF')
        ->landlord_id->toBe($landlord->id); // Ensure automatic scoping worked

    // Verify room status updated
    $room->refresh();

    expect($room)
        ->active_occupants->toBe(1)
        ->occupancy_status->toBe('Terisi');
});

test('registerTenant throws exception if room is full', function () {
    $landlord = Landlord::factory()->create();
    $user = User::factory()->create(['landlord_id' => $landlord->id]);
    $room = Room::factory()->create([
        'landlord_id' => $landlord->id,
        'occupancy_status' => 'Terisi',
    ]);

    actingAs($user);

    $service = new TenantService();
    $data = [
        'name' => 'Jane Doe',
        'gender' => 'Perempuan', // Gender doesn't matter here, should fail on status
        'phone' => '08123456789',
        'ktp_url' => 'https://example.com/ktp.jpg',
        'check_in_date' => '2026-01-01',
        'room_id' => $room->id,
    ];

    expect(fn() => $service->registerTenant($data))
        ->toThrow(ValidationException::class);
});

test('registerTenant throws exception if gender mismatch', function () {
    $landlord = Landlord::factory()->create();
    $user = User::factory()->create(['landlord_id' => $landlord->id]);
    $room = Room::factory()->create([
        'landlord_id' => $landlord->id,
        'room_type' => 'Putra',
        'occupancy_status' => 'Tersedia',
    ]);

    actingAs($user);

    $service = new TenantService();
    $data = [
        'name' => 'Jane Doe',
        'gender' => 'Perempuan', // Mismatch (Perempuan -> Putri != Putra)
        'phone' => '08123456789',
        'ktp_url' => 'https://example.com/ktp.jpg',
        'check_in_date' => '2026-01-01',
        'room_id' => $room->id,
    ];

    expect(fn() => $service->registerTenant($data))
        ->toThrow(ValidationException::class);
});
