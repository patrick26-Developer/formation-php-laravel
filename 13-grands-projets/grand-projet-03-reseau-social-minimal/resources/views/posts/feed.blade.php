<x-app-layout>
    <div class="p-6">
        <h1>Fil d'actualité</h1>

        <form method="POST" action="{{ route('posts.store') }}">
            @csrf
            <textarea name="contenu" placeholder="Quoi de neuf ?" maxlength="500" required></textarea>
            <button type="submit">Publier</button>
        </form>

        @foreach ($posts as $post)
            <div style="border-bottom:1px solid #eee; padding:1rem 0;">
                <strong>{{ $post->user->name }}</strong>
                <p>{{ $post->contenu }}</p>
                <small>{{ $post->created_at->diffForHumans() }}</small>

                <form method="POST" action="{{ route('like.basculer', $post) }}" style="display:inline;">
                    @csrf
                    <button type="submit">
                        {{ $post->estAimeParL(auth()->user()) ? '❤️' : '🤍' }} {{ $post->likedBy->count() }}
                    </button>
                </form>

                @if ($post->user_id !== auth()->id())
                    <form method="POST" action="{{ route('follow.basculer', $post->user) }}" style="display:inline;">
                        @csrf
                        <button type="submit">
                            {{ auth()->user()->suit($post->user) ? 'Ne plus suivre' : 'Suivre' }}
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('posts.destroy', $post) }}" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit">Supprimer</button>
                    </form>
                @endif
            </div>
        @endforeach

        {{ $posts->links() }}
    </div>
</x-app-layout>
