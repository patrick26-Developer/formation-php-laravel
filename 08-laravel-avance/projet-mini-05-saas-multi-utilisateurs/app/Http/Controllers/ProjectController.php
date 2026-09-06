<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Jobs\GenererRapportHebdomadaire;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $tenantId = $request->user()->tenant_id;

        // Cache paramétré par tenant (module 08.2) : chaque tenant a sa
        // propre entrée, jamais partagée avec un autre.
        $statistiques = Cache::remember(
            "dashboard.statistiques.tenant.{$tenantId}",
            now()->addMinutes(10),
            fn () => [
                'projets_actifs' => Project::actifs()->count(), // le scope global filtre déjà par tenant
                'projets_totaux' => Project::count(),
            ]
        );

        $projets = Project::with('tasks')->latest()->paginate(10);

        return view('projects.index', compact('projets', 'statistiques'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
        ]);

        Project::create($data); // tenant_id assigné automatiquement (Model Event "creating")

        Cache::forget("dashboard.statistiques.tenant.{$request->user()->tenant_id}");

        return redirect()->route('projects.index')->with('succes', 'Projet créé.');
    }

    public function show(Project $project): View
    {
        $this->authorize('view', $project);

        $project->load('tasks');

        return view('projects.show', compact('project'));
    }

    public function destroy(Request $request, Project $project): RedirectResponse
    {
        $this->authorize('delete', $project);

        $project->delete();

        Cache::forget("dashboard.statistiques.tenant.{$request->user()->tenant_id}");

        return redirect()->route('projects.index')->with('succes', 'Projet supprimé.');
    }

    public function genererRapport(Request $request): RedirectResponse
    {
        GenererRapportHebdomadaire::dispatch($request->user()->tenant);

        return back()->with('succes', 'Génération du rapport lancée en arrière-plan.');
    }
}
