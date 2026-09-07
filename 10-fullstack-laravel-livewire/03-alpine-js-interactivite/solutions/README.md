# Solutions — 10.3 Alpine.js pour l'interactivité légère

## Exercice 1

```blade
<div x-data="{ ouvert: false }" class="relative">
    <button @click="ouvert = !ouvert">Menu</button>
    <div x-show="ouvert" @click.outside="ouvert = false">
        <a href="#">Option 1</a>
        <a href="#">Option 2</a>
    </div>
</div>
```

## Exercice 2

```blade
<div x-data="{ onglet: 'infos' }">
    <button @click="onglet = 'infos'">Infos</button>
    <button @click="onglet = 'avis'">Avis</button>

    <div x-show="onglet === 'infos'">Contenu des informations.</div>
    <div x-show="onglet === 'avis'">Contenu des avis.</div>
</div>
```

## Exercice 3

```blade
<div x-data="{ visible: false }">
    <input :type="visible ? 'text' : 'password'" name="mot_de_passe">
    <button type="button" @click="visible = !visible">
        <span x-text="visible ? 'Masquer' : 'Afficher'"></span>
    </button>
</div>
```

## Exercice 4

```blade
<div x-data="{ confirmerExtinction() { return this.actif ? confirm('Vraiment éteindre ?') : true; } }">
    <button
        wire:click="basculer"
        @click="if ($wire.actif && !confirm('Vraiment éteindre ?')) $event.stopImmediatePropagation()"
    >
        Basculer
    </button>
</div>
```
*(Pattern simplifié : dans un vrai projet, on utiliserait plutôt
`wire:confirm="Vraiment éteindre ?"`, une directive Livewire dédiée à cet
usage exact.)*

## Exercice 5

```blade
<div x-data>
    <p>Valeur en temps réel : <span x-text="$wire.total"></span></p>
    <button @click="$wire.incrementer()">Incrémenter</button>
</div>
```
Ce bouton déclenche bien une requête serveur car `$wire.incrementer()`
appelle une MÉTHODE PHP du composant Livewire (définie côté serveur) —
contrairement aux exercices 1 à 3, où `ouvert`, `onglet`, `visible` sont
des variables JavaScript PURES, qui n'existent que dans le navigateur et
n'ont aucune contrepartie côté serveur à interroger.
