<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rabbit extends Model
{
    /** @use HasFactory<\Database\Factories\RabbitFactory> */
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'name',
        'tattoo_id',
        'sex',
        'sire_id',
        'dam_id',
    ];

    public function sire(): BelongsTo
    {
        return $this->belongsTo(Rabbit::class, 'sire_id');
    }

    public function dam(): BelongsTo
    {
        return $this->belongsTo(Rabbit::class, 'dam_id');
    }
}
