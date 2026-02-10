<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\BelongsToLandlord;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentMethod extends Model
{
    use HasFactory;
    use BelongsToLandlord;

    protected $fillable = [
        'landlord_id',
        'gateway_type',
        'gateway_name',
        'is_active',
        'is_default',
        'api_key',
        'api_secret',
        'merchant_id',
        'webhook_secret',
        'configuration',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'configuration' => 'array',
        'api_key' => 'encrypted',
        'api_secret' => 'encrypted',
        'webhook_secret' => 'encrypted',
    ];
}
