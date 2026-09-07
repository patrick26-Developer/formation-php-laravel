# Build Journal

## Step 1 — Reusing, again: no new model

Like the level 09 mini-project, this dashboard introduces **no** new Eloquent model: `Annonce`, `Category`, and their scopes (`actives()`, `deLaCategorie()`) come as-is from level 07. Only an `est_admin` column is added to `users`, via an additive migration — never by modifying an existing migration (a reminder from module 06.5).

## Step 2 — `AnnoncesTable`, a synthesis of module 10.4

This component is a direct transposition of the [module 10.4](../04-tables-dynamiques-tri-filtre-recherche/README.en.md) example: same `#[Url]`, same whitelist of sortable columns, same `updatingRecherche()` hook. The only novelty specific to this project: the `basculerStatut()` and `supprimer()` methods, which modify a listing and then call `$this->dispatch('statistiques-modifiees')`.

## Step 3 — `StatistiquesWidget`, decoupled by design

This component has **no reference** to `AnnoncesTable` in its code: it simply listens for a named event (`#[On('statistiques-modifiees')]`). This decision means that tomorrow, a third source of events (for example, a bulk action from another page) can be added without ever modifying `StatistiquesWidget` — the same decoupling benefit as the Events/Listeners from [module 08.1](../../08-laravel-avance/01-jobs-queues-events-listeners/README.en.md), applied here to communication between UI components rather than business classes.

## Step 4 — Alpine for confirmation, never for the data

The "Delete" button combines `x-on:click` (Alpine, purely client-side: `confirm()` is a native browser JavaScript function, no server round trip) and `$wire.supprimer(...)` (Livewire, which actually performs the deletion in the database). This clean separation directly follows the rule from [module 10.3](../03-alpine-js-interactivite/README.en.md): Alpine handles "did the user visually confirm?", Livewire handles "should the data actually change?".

## Step 5 — Testing a Livewire component like any other Laravel code

`AnnoncesTableTest` uses `Livewire::test()` (module 10.4, extended by the dedicated Pest plugin) to drive the component exactly as a user would: `set('recherche', ...)`, `call('basculerStatut', ...)`, then assertions on the rendered HTML or the database state. The test on pagination reset (`updatingRecherche()`) proves a behavior that, without it, would be a bug easily introduced by mistake during a future modification of the component.

## Going further (out of scope for this mini-project)

No bulk action (selecting several listings to deactivate them at once) is implemented, and the `acceder-admin` Gate stays minimal (a simple boolean, not a full role system) — extended by the multi-role Policy concept already seen in module 07.5, to be developed further as an exercise.
