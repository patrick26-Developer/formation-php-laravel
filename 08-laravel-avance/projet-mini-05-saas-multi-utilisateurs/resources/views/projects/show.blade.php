<x-app-layout>
    <div class="p-6">
        <p><a href="{{ route('projects.index') }}">← Retour</a></p>
        <h1>{{ $project->nom }}</h1>
        <p>{{ $project->description }}</p>

        <h2>Tâches</h2>
        <ul>
            @foreach ($project->tasks as $tache)
                <li>{{ $tache->terminee ? '✅' : '🕓' }} {{ $tache->titre }}</li>
            @endforeach
        </ul>
    </div>
</x-app-layout>
