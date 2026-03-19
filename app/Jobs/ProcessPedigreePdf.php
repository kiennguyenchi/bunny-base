<?php

namespace App\Jobs;

use App\Models\Rabbit;
use App\Models\User;
use App\Services\PedigreeEngine;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;

class ProcessPedigreePdf implements ShouldQueue
{
    use Dispatchable;

    public function __construct(public Rabbit $rabbit, public User $user) {}

    public function handle(PedigreeEngine $engine): void
    {
        $tree = $engine->getTree($this->rabbit);

        // For demonstration, I print the tree structure to the queue:worker console
        print_r($tree->toArray());

        // In reality, here is my approach
        // 1. Generate PDF
        // 2. Dispatch a notification to the user with a link to download the PDF
        // 3. Store the PDF in a private disk and serve it through a secure route
    }
}
