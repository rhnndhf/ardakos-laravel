<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\BelongsToLandlord;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    use HasFactory;
    use BelongsToLandlord;

    protected $fillable = [
        'landlord_id',
        'room_id',
        'plate_number',
        'vehicle_type',
        'user_type',
        'status',
        'stnk_url',
        'last_payment_period',
        'notes',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
