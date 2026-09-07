# Build Journal

## Step 1 — One pivot table, two reading directions

`follows` has two columns (`follower_id`, `followed_id`), both pointing to `users`. `User::following()` and `User::followers()` query the **same table**, but with the local/foreign columns swapped (`belongsToMany(User::class, 'follows', 'follower_id', 'followed_id')` vs. the reverse). This is the direct application of the self-referencing relationship from [module 07.1](../../07-laravel-intermediaire/01-eloquent-relations-avancees/README.en.md), with the added difficulty that the pivot table connects a model to **itself**.

## Step 2 — The news feed: a single query, not a loop

`feed()` first computes the list of relevant IDs (`following()->pluck('users.id')->push($utilisateur->id)`), THEN runs a single `whereIn('user_id', $idsSuivis)` query. The alternative — looping over each followed account and merging results in PHP — would have been a direct performance trap, the N+1 problem (module 03.6) applied to business logic rather than a simple relationship display.

## Step 3 — Notifying with discernment, not systematically

Two explicit safeguards prevent useless or absurd notifications: `FollowController::basculer()` refuses to let a user follow themselves (`if ($utilisateurConnecte->id === $user->id)`), and `LikeController::basculer()` only notifies the author IF the "liker" isn't the author themselves. Without these checks, a user would get a "you started following yourself" or "you liked your own post" notification — useless noise that would quickly erode trust in the notification center.

## Step 4 — The same model, two presentations

`PostResource` (used by `Api\FeedController`) computes `aime_par_moi` via `estAimeParL($request->user())`, the SAME method the Blade view (`posts/feed.blade.php`) uses to display ❤️/🤍. No logic is duplicated between the two surfaces (web and API) — only the final representation (HTML vs. JSON) differs, exactly the principle already applied in the [level 09 mini-project](../../09-api-rest-laravel/projet-mini-06-api-rest-complete/README.en.md).

## Step 5 — `withCount`/`whenCounted` rather than loading the whole relationship

The API uses `withCount('likedBy')` then `whenCounted('likedBy')` in the Resource — this only retrieves a **count** (`likedBy_count`), not the full list of users who liked each post (potentially hundreds), unnecessary for a simple counter display. The Blade view, on the other hand, loads the full relationship (`likedBy`) because it needs to know whether the specifically LOGGED-IN user is part of it — two different needs, two different loading strategies, both deliberate.

## Going further (out of scope for this project)

No comment system, no sharing, no "discover" feed (account suggestions) — the minimal core (post, follow, like, get notified) is complete, the rest is a natural extension left as an exercise.
