<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Notifications\PostAimeNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function basculer(Request $request, Post $post): RedirectResponse
    {
        $utilisateur = $request->user();

        if ($post->estAimeParL($utilisateur)) {
            $post->likedBy()->detach($utilisateur->id);
        } else {
            $post->likedBy()->attach($utilisateur->id);

            // On ne notifie jamais un utilisateur qui aime sa PROPRE publication.
            if ($post->user_id !== $utilisateur->id) {
                $post->user->notify(new PostAimeNotification($post, $utilisateur));
            }
        }

        return back();
    }
}
