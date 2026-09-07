<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index(Request $request)
    {
        $utilisateur = $request->user();
        $idsSuivis = $utilisateur->following()->pluck('users.id')->push($utilisateur->id);

        $posts = Post::query()
            ->with('user')
            ->withCount('likedBy')
            ->whereIn('user_id', $idsSuivis)
            ->latest()
            ->paginate(15);

        return PostResource::collection($posts);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['contenu' => ['required', 'string', 'max:500']]);

        $post = $request->user()->posts()->create($data);

        return (new PostResource($post->load('user')))->response()->setStatusCode(201);
    }
}
