<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\BelongsToLandlord;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;
    use BelongsToLandlord;

    protected $fillable = [
        'landlord_id',
        'room_id',
        'tenant_id',
        'transaction_type',
        'period',
        'amount',
        'description',
        'payment_proof_url',
        'actor_email',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
