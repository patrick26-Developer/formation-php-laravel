# 10.2 — Composants réactifs et formulaires

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Lier un champ de formulaire à une propriété avec `wire:model`.
- Valider un formulaire Livewire en temps réel.
- Émettre et écouter des événements entre composants.
- Comprendre `wire:model.live` vs `wire:model` (déferred).

## 📋 Prérequis

[10.1 — Livewire : les fondamentaux](../01-livewire-fondamentaux/README.md), [06.6 — Validation des formulaires](../../06-laravel-fondamentaux/06-validation-formulaires/README.md)

## ⏱️ Durée estimée

2h30.

## 📖 Théorie

### `wire:model` : lier un champ à une propriété

```php
class FormulaireTache extends Component
{
    public string $titre = '';
    public string $description = '';

    public function creer(): void
    {
        Tache::create(['titre' => $this->titre, 'description' => $this->description]);
        $this->reset(['titre', 'description']); // vide le formulaire après création
    }

    public function render() { return view('livewire.formulaire-tache'); }
}
```

```blade
<form wire:submit="creer">
    <input type="text" wire:model="titre">
    <textarea wire:model="description"></textarea>
    <button type="submit">Créer</button>
</form>
```

> 💡 `wire:model="titre"` synchronise automatiquement la valeur du champ avec `$this->titre` côté serveur — l'équivalent de lire `$_POST['titre']` (module 01.7), mais mis à jour en continu plutôt qu'au moment de la soumission.

### `wire:model` (déferred) vs `wire:model.live`

| | `wire:model` | `wire:model.live` |
|---|---|---|
| Quand la synchronisation a lieu | Au prochain événement réseau (ex : soumission du formulaire) | À **chaque frappe clavier**, immédiatement |
| Coût réseau | Faible (une seule requête à la soumission) | Élevé (une requête par frappe) |
| Cas d'usage | La majorité des formulaires classiques | Recherche en temps réel (module 10.4), aperçu instantané |

> ⚠️ Utiliser `.live` par défaut sur tous les champs est un anti-pattern de performance : chaque frappe déclenche une requête AJAX complète (module 08.2 : mesurer avant d'optimiser s'applique aussi à l'usage de Livewire). Réservez `.live` aux champs qui ont **réellement** besoin d'une réaction immédiate.

### Validation en temps réel

```php
use Livewire\Attributes\Rule;

class FormulaireTache extends Component
{
    #[Rule('required|min:3|max:150')]
    public string $titre = '';

    public function creer(): void
    {
        $this->validate(); // applique les règles déclarées avec #[Rule]

        Tache::create(['titre' => $this->titre]);
        $this->reset('titre');
    }
}
```

```blade
<input type="text" wire:model="titre">
@error('titre') <span class="text-red-500">{{ $message }}</span> @enderror
```

> 📌 Exactement les mêmes règles de validation que les Form Requests (module 06.6) — Livewire réutilise le **même** validateur Laravel sous-jacent, seule la façon de le déclencher change (`$this->validate()` dans une méthode, plutôt qu'automatique sur toute la requête HTTP).

### Validation en temps réel, à chaque changement

```php
public function updated($property): void
{
    $this->validateOnly($property); // valide UNIQUEMENT le champ qui vient de changer
}
```

```blade
<input type="text" wire:model.live="titre">
```

> 💡 Combiné à `wire:model.live`, cela affiche une erreur de validation **au fur et à mesure de la saisie**, sans attendre la soumission — une expérience utilisateur proche d'une SPA moderne, entièrement en PHP.

### Communication entre composants : événements

```php
// Composant A : émet un événement après création
class FormulaireTache extends Component
{
    public function creer(): void
    {
        $this->validate();
        Tache::create(['titre' => $this->titre]);
        $this->dispatch('tache-creee'); // émet un événement nommé
        $this->reset('titre');
    }
}
```

```php
// Composant B : écoute l'événement et se rafraîchit
class ListeTaches extends Component
{
    #[\Livewire\Attributes\On('tache-creee')]
    public function rafraichir(): void
    {
        // Le simple fait que cette méthode existe et écoute l'événement
        // suffit à déclencher un nouveau render() de ce composant.
    }

    public function render()
    {
        return view('livewire.liste-taches', ['taches' => Tache::latest()->get()]);
    }
}
```

> 📌 C'est le pattern **Observer** (module 03.1) une nouvelle fois, appliqué cette fois à la communication **entre composants d'interface** plutôt qu'entre classes métier — un composant "Formulaire" n'a jamais besoin de connaître directement le composant "Liste" pour le notifier d'un changement.

## ✅ Points clés à retenir

- `wire:model` synchronise un champ avec une propriété ; `.live` la synchronise à chaque frappe (coûteux, à réserver aux cas qui l'exigent réellement).
- `#[Rule(...)]` + `$this->validate()` réutilisent le même validateur que les Form Requests.
- `validateOnly()` valide un seul champ, utile pour une validation en temps réel ciblée.
- `dispatch()`/`#[On(...)]` permettent à des composants de communiquer sans se connaître directement.

## ➡️ Pour aller plus loin

- [livewire.laravel.com/docs/forms](https://livewire.laravel.com/docs/forms)
- [livewire.laravel.com/docs/events](https://livewire.laravel.com/docs/events)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [10.1 — Livewire : les fondamentaux](../01-livewire-fondamentaux/README.md) · **Suite :** [10.3 — Alpine.js pour l'interactivité légère](../03-alpine-js-interactivite/README.md)
