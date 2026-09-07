<x-app-layout>
    <div class="p-6">
        <h1>Projets — {{ auth()->user()->tenant->nom }}</h1>

        @if ($abonnement)
            <p>Plan : {{ $abonnement->plan->nom }} ({{ $abonnement->plan->limite_projets === 0 ? 'illimité' : $abonnement->plan->limite_projets . ' projets max' }})</p>
        @else
            <p style="color:red;">Aucun abonnement actif.</p>
        @endif

        @if (session('erreur')) <p style="color:red">{{ session('erreur') }}</p> @endif
        @if (session('succes')) <p style="color:green">{{ session('succes') }}</p> @endif

        <form method="POST" action="{{ route('projects.store') }}">
            @csrf
            <input type="text" name="nom" placeholder="Nom du projet" required>
            <button type="submit">Créer</button>
        </form>

        <ul>
            @foreach ($projects as $project)
                <li>{{ $project->nom }}</li>
            @endforeach
        </ul>

        {{ $projects->links() }}
    </div>
</x-app-layout>
