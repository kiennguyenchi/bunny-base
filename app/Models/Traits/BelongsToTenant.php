<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;

trait BelongsToTenant
{
    protected static function booted()
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (App::bound('tenant_id')) {
                $builder->where('tenant_id', App::make('tenant_id'));
            }
        });

        static::creating(function ($model) {
            if (App::bound('tenant_id')) {
                $model->tenant_id = App::make('tenant_id');
            }
        });
    }
}
