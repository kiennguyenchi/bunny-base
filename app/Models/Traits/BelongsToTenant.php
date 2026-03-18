<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant()
    {
        // 1. Automatically filter every SELECT query
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (App::bound('tenant_id')) {
                $builder->where('tenant_id', App::make('tenant_id'));
            }
        });

        // 2. Automatically assign tenant_id on every CREATE
        static::creating(function ($model) {
            if (App::bound('tenant_id') && ! $model->tenant_id) {
                $model->tenant_id = App::make('tenant_id');
            }
        });
    }
}
