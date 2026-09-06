<x-app-layout>
    <div class="p-6">
        <h1>Tableau de bord — {{ auth()->user()->tenant->nom }}</h1>

        <p>Projets actifs : {{ $statistiques['projets_actifs'] }} / {{ $statistiques['projets_totaux'] }} au total</p>

        @if (session('succes'))
            <p style="color:green;">{{ session('succes') }}</p>
        @endif

        <form method="POST" action="{{ route('rapport.generer') }}">
            @csrf
            <button type="submit">Générer le rapport hebdomadaire</button>
        </form>

        <h2>Nouveau projet</h2>
        <form method="POST" action="{{ route('projects.store') }}">
            @csrf
            <input type="text" name="nom" placeholder="Nom du projet" required>
            <textarea name="description" placeholder="Description"></textarea>
            <button type="submit">Créer</button>
        </form>

        <h2>Projets</h2>
        <ul>
            @foreach ($projets as $projet)
                <li>
                    <a href="{{ route('projects.show', $projet) }}">{{ $projet->nom }}</a>
                    ({{ $projet->tasks->where('terminee', true)->count() }}/{{ $projet->tasks->count() }} tâches terminées)
                    <form method="POST" action="{{ route('projects.destroy', $projet) }}" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Supprimer ?')">Supprimer</button>
                    </form>
                </li>
            @endforeach
        </ul>

        {{ $projets->links() }}
    </div>
</x-app-layout>
