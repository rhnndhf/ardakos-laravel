<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\BelongsToLandlord;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomAccessLog extends Model
{
    use HasFactory;
    use BelongsToLandlord;

    protected $fillable = [
        'landlord_id',
        'room_id',
        'tenant_id',
        'room_lock_id',
        'event_type',
        'pin_code',
        'access_method',
        'granted_at',
        'revoked_at',
        'expires_at',
        'metadata',
    ];

    protected $casts = [
        'granted_at' => 'datetime',
        'revoked_at' => 'datetime',
        'expires_at' => 'datetime',
        'metadata' => 'array',
    ];
}
