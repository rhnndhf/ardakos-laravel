<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\BelongsToLandlord;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Room extends Model
{
    use HasFactory;
    use BelongsToLandlord;

    protected $fillable = [
        'landlord_id',
        'room_number',
        'floor',
        'base_price',
        'room_type',
        'occupancy_status',
        'active_occupants',
        'facilities',
        'condition_notes',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'active_occupants' => 'integer',
    ];

    public function tenants(): HasMany
    {
        return $this->hasMany(Tenant::class);
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    public function inventories(): HasMany
    {
        return $this->hasMany(RoomInventory::class);
    }

    public function maintenanceLogs(): HasMany
    {
        return $this->hasMany(MaintenanceLog::class);
    }

    public function inspections(): HasMany
    {
        return $this->hasMany(RoomInspection::class);
    }

    public function lock(): HasOne
    {
        return $this->hasOne(RoomLock::class);
    }
}
