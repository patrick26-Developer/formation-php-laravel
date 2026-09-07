# 10.1 — Livewire : les fondamentaux

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre le principe de fonctionnement de Livewire.
- Créer un premier composant Livewire avec état réactif.
- Comprendre le cycle requête/réponse d'un composant.
- Choisir entre Livewire et une API séparée selon le besoin.

## 📋 Prérequis

[Niveau 09 — API REST avec Laravel](../../09-api-rest-laravel/README.md), [06.3 — Blade](../../06-laravel-fondamentaux/03-blade-templates/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### Le problème que Livewire résout

Au niveau 09, construire une interface réactive (recherche instantanée, compteur qui se met à jour sans recharger la page) aurait nécessité une API JSON **et** du JavaScript côté client pour l'appeler. **Livewire** permet le même résultat en écrivant **uniquement du PHP et du Blade** : chaque interaction déclenche une requête AJAX automatique, gérée entièrement par le framework, qui ré-exécute le composant côté serveur et ne renvoie que le HTML qui a changé.

### Installer Livewire

```bash
composer require livewire/livewire
```

### Créer un premier composant

```bash
php artisan make:livewire Compteur
```

```php
// app/Livewire/Compteur.php
namespace App\Livewire;

use Livewire\Component;

class Compteur extends Component
{
    public int $total = 0; // une PROPRIÉTÉ PUBLIQUE = un état réactif

    public function incrementer(): void
    {
        $this->total++;
    }

    public function render()
    {
        return view('livewire.compteur');
    }
}
```

```blade
{{-- resources/views/livewire/compteur.blade.php --}}
<div>
    <p>Total : {{ $total }}</p>
    <button wire:click="incrementer">+1</button>
</div>
```

```blade
{{-- Dans n'importe quelle page --}}
<livewire:compteur />
```

> 💡 `wire:click="incrementer"` déclenche, au clic, une requête AJAX **automatique** vers le serveur, qui exécute `incrementer()`, ré-exécute `render()`, et ne renvoie que le HTML modifié — sans qu'une seule ligne de JavaScript n'ait été écrite. Comparez avec le [module 01.7](../../01-php-fondamentaux/07-formulaires-http-get-post/README.md) : ce même besoin ("mettre à jour une valeur sans recharger toute la page") aurait nécessité un formulaire complet avec rechargement de page en PHP pur.

### Le cycle de vie d'un composant

1. **Montage initial** : `mount()` (optionnel, équivalent d'un constructeur) initialise les propriétés.
2. **Rendu initial** : `render()` affiche le composant dans la page HTML classique (premier chargement).
3. **Interactions** : chaque `wire:click`, `wire:model`, etc. déclenche une requête AJAX qui ré-exécute le composant entier côté serveur et mémorise l'état des propriétés publiques entre chaque requête.

```php
class Compteur extends Component
{
    public int $total;

    public function mount(int $valeurInitiale = 0): void
    {
        $this->total = $valeurInitiale;
    }
}
```

```blade
<livewire:compteur :valeur-initiale="10" />
```

### Propriétés publiques : la mémoire de l'état entre les requêtes

> ⚠️ Une propriété publique Livewire est **sérialisée et renvoyée** au client à chaque rendu, puis **renvoyée au serveur** à chaque interaction suivante. Ne stockez jamais de données sensibles (mot de passe, jeton) dans une propriété publique : elle est visible dans le HTML/payload réseau, exactement comme un champ de formulaire caché.

### Quand choisir Livewire plutôt qu'une API + JavaScript (niveau 09) ?

| | Livewire | API + Frontend JS séparé (Vue/React) |
|---|---|---|
| Langages à maîtriser | PHP + Blade uniquement | PHP (API) + JavaScript (frontend) |
| Cas d'usage | Back-offices, formulaires complexes, interfaces admin, MVP | Applications mobile natives, SPA complexes, équipes frontend séparées |
| Courbe d'apprentissage | Faible pour un développeur déjà à l'aise avec Laravel | Nécessite une expertise JS/frontend distincte |

> 📌 Pour cette formation et la majorité des projets internes/back-office, **Livewire est le choix recommandé** : il évite de maintenir deux bases de code (backend + frontend) et une équipe séparée n'est pas nécessaire. Une API REST (niveau 09) reste indispensable si une application **mobile native** doit consommer les mêmes données.

## ✅ Points clés à retenir

- Un composant Livewire est une classe PHP avec des propriétés publiques réactives et une vue Blade associée.
- `wire:click` (et les autres directives `wire:*`) déclenchent des requêtes AJAX automatiques, sans JavaScript à écrire.
- Une propriété publique est visible côté client : ne jamais y stocker de données sensibles.
- Livewire convient aux back-offices et interfaces internes ; une API séparée reste nécessaire pour du mobile natif.

## ➡️ Pour aller plus loin

- [livewire.laravel.com/docs](https://livewire.laravel.com/docs)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [Niveau 09 — API REST Laravel](../../09-api-rest-laravel/README.md) · **Suite :** [10.2 — Composants réactifs et formulaires](../02-composants-reactifs-formulaires/README.md)
