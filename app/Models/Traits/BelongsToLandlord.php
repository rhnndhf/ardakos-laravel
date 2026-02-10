<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Models\Landlord;
use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

trait BelongsToLandlord
{
    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope());

        static::creating(function (Model $model) {
            if (Auth::check() && Auth::user()->landlord_id) {
                $model->landlord_id = Auth::user()->landlord_id;
            }
        });
    }

    public function landlord(): BelongsTo
    {
        return $this->belongsTo(Landlord::class);
    }
}
