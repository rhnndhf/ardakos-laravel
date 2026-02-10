<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Room;
use App\Models\User;

class RoomService
{
    /**
     * Calculate dynamic pricing based on base price and extra rules.
     */
    public function calculatePrice(Room $room): float
    {
        // Future: Implement dynamic pricing rules if needed
        return (float) $room->base_price;
    }

    /**
     * Check if a room is available for a specific gender.
     */
    public function isAvailableFor(Room $room, string $gender): bool
    {
        if ($room->occupancy_status === 'Terisi') {
            return false;
        }

        if ($room->room_type === 'Campur') {
            return true;
        }

        return $room->room_type === $gender;
    }
}
