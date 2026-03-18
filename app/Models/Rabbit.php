<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
