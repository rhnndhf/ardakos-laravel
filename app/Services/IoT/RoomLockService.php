<?php

declare(strict_types=1);

namespace App\Services\IoT;

use App\Models\Room;
use App\Models\RoomAccessLog;
use App\Models\RoomLock;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class RoomLockService
{
    /**
     * Generate a new PIN code for a room lock.
     */
    public function generatePin(Room $room, string $name, string $startDate, string $endDate): string
    {
        $lock = $room->lock;

        if (! $lock) {
            throw new RuntimeException('Room does not have a smart lock configured.');
        }

        if ($lock->lock_type === 'Manual') {
            return '123456'; // Fallback / Placeholder for manual locks
        }

        // Potential integration with TTLock API
        // $response = Http::post('https://api.ttlock.com/v3/keyboardPwd/get', [
        //     'clientId' => config('services.ttlock.client_id'),
        //     'accessToken' => $lock->metadata['access_token'] ?? '',
        //     'lockId' => $lock->lock_id,
        //     'keyboardPwdName' => $name,
        //     'startDate' => strtotime($startDate) * 1000,
        //     'endDate' => strtotime($endDate) * 1000,
        // ]);

        // Placeholder logic for simulation
        $pin = (string) rand(100000, 999999);

        // Log the generation event
        RoomAccessLog::create([
            'landlord_id' => $room->landlord_id,
            'room_id' => $room->id,
            'room_lock_id' => $lock->id,
            'event_type' => 'PIN_Generated',
            'pin_code' => $pin,
            'metadata' => [
                'name' => $name,
                'start' => $startDate,
                'end' => $endDate,
            ],
        ]);

        return $pin;
    }

    /**
     * Sync lock status from the provider.
     */
    public function syncLockStatus(RoomLock $lock): void
    {
        if ($lock->lock_type === 'Manual') {
            return;
        }

        // Simulate sync
        $lock->update([
            'battery_level' => rand(80, 100),
            'is_online' => true,
            'last_synced_at' => now(),
            'sync_status' => 'Synced',
        ]);

        RoomAccessLog::create([
            'landlord_id' => $lock->landlord_id,
            'room_id' => $lock->room_id,
            'room_lock_id' => $lock->id,
            'event_type' => 'PIN_Synced',
            'metadata' => ['status' => 'success'],
        ]);
    }
}
