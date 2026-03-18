<?php

namespace App\Services;

use App\Models\Rabbit;

class PedigreeEngine
{
    /**
     * Recursively loads ancestors up to 3 generations
     */
    public function getTree(Rabbit $rabbit)
    {
        return $rabbit->load([
            'sire.sire',
            'sire.dam',
            'dam.sire',
            'dam.dam'
        ]);
    }
}
