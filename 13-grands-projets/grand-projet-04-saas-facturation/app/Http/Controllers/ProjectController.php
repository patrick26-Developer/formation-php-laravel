<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\LimitePlanAtteinteException;
use App\Models\Project;
use App\Services\PlanLimitService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        return view('projects.index', [
            'projects' => Project::latest()->paginate(10),
            'abonnement' => $request->user()->tenant->abonnementActif,
        ]);
    }

    public function store(Request $request, PlanLimitService $limites): RedirectResponse
    {
        $data = $request->validate(['nom' => ['required', 'string', 'max:150']]);

        try {
            $limites->verifierLimiteProjets($request->user()->tenant);
        } catch (LimitePlanAtteinteException $e) {
            return back()->with('erreur', $e->getMessage());
        }

        Project::create($data);

        return back()->with('succes', 'Projet créé.');
    }
}
