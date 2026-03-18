<?php

namespace App\Jobs;

use App\Models\Rabbit;
use App\Services\PedigreeEngine;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessPedigreePdf implements ShouldQueue
{
    use Dispatchable;

    public function __construct(public Rabbit $rabbit) {}

    public function handle(PedigreeEngine $engine)
    {
        $tree = $engine->getTree($this->rabbit);
        print_r($tree->toArray()); // For demonstration, replace with actual PDF generation logic
    }
}
