<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (Auth::check()) {
            $user = Auth::user();

            // If user has a landlord_id, scope query to that landlord
            if ($user->landlord_id) {
                $builder->where($model->getTable() . '.landlord_id', '=', $user->landlord_id);
            }
        }
    }
}
