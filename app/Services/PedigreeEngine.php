<?php

namespace App\Services;

use App\Models\Rabbit;

class PedigreeEngine
{
    public function getTree(Rabbit $rabbit, int $depth = 2): Rabbit
    {
        $relations = $this->generatePedigreePaths($depth);
        return $rabbit->load($relations);
    }

    private function generatePedigreePaths(int $depth, $prefix = ''): array
    {
        if ($depth <= 0) return [];

        $paths = [
            ($prefix ? $prefix . '.' : '') . 'sire',
            ($prefix ? $prefix . '.' : '') . 'dam',
        ];

        // Recurse to build the next level
        $sirePaths = $this->generatePedigreePaths($depth - 1, ($prefix ? $prefix . '.' : '') . 'sire');
        $damPaths = $this->generatePedigreePaths($depth - 1, ($prefix ? $prefix . '.' : '') . 'dam');

        return array_merge($paths, $sirePaths, $damPaths);
    }
}
