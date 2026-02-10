<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\BelongsToLandlord;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomLock extends Model
{
    use HasFactory;
    use BelongsToLandlord;

    protected $fillable = [
        'landlord_id',
        'room_id',
        'lock_id',
        'lock_type',
        'lock_mac_address',
        'lock_model',
        'current_pin',
        'pin_expires_at',
        'sync_status',
        'last_synced_at',
        'battery_level',
        'is_online',
        'firmware_version',
        'metadata',
    ];

    protected $casts = [
        'is_online' => 'boolean',
        'pin_expires_at' => 'datetime',
        'last_synced_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
