<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRabbitRequest;
use App\Jobs\ProcessPedigreePdf;
use App\Models\Rabbit;
use App\Services\PedigreeEngine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class RabbitController extends Controller
{
    public function index(): Response
    {
        Gate::authorize('viewAny', Rabbit::class);

        return Inertia::render('Rabbits/Index', [
            'rabbits' => Rabbit::with(['sire', 'dam'])->latest()->get()
        ]);
    }

    public function show(Request $request, Rabbit $rabbit, PedigreeEngine $engine): Response
    {
        Gate::authorize('view', $rabbit);

        return Inertia::render('Rabbits/Show', [
            'rabbit' => $engine->getTree($rabbit),
        ]);
    }

    public function create(Request $request): Response
    {
        Gate::authorize('create', Rabbit::class);

        $tenant = $request->user()->tenant;

        return Inertia::render('Rabbits/Create', [
            'bucks' => $tenant->rabbits()->where('sex', 'buck')->get(['id', 'name']),
            'does' => $tenant->rabbits()->where('sex', 'doe')->get(['id', 'name']),
        ]);
    }

    public function store(StoreRabbitRequest $request): RedirectResponse
    {
        Rabbit::create($request->validated());

        return redirect()->route('rabbits.index');
    }

    public function downloadPedigree(Request $request, Rabbit $rabbit): RedirectResponse
    {
        Gate::authorize('view', $rabbit);

        ProcessPedigreePdf::dispatch($rabbit, $request->user());

        return redirect()->back()->with('status', 'Pedigree PDF generation has been started. It will be available for download shortly. (For demonstration, I print the tree structure to the queue:worker console)');
    }
}
