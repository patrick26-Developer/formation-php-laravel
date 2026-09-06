# 07.6 — Upload de fichiers et Storage

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre le système de disques (`Storage`) de Laravel.
- Gérer l'upload, le stockage et la suppression de fichiers.
- Valider des fichiers uploadés (type, taille).
- Afficher des fichiers stockés publiquement.

## 📋 Prérequis

[07.5 — Autorisations : Policies et Gates](../05-autorisations-policies-gates/README.md)

## ⏱️ Durée estimée

1h30.

## 📖 Théorie

### Le système de disques Laravel

Laravel abstrait le stockage de fichiers derrière une interface unique (`Storage`), quel que soit le support réel (disque local, S3, etc.), configuré dans `config/filesystems.php` :

```php
// config/filesystems.php
'disks' => [
    'local' => ['driver' => 'local', 'root' => storage_path('app/private')],
    'public' => ['driver' => 'local', 'root' => storage_path('app/public'), 'url' => env('APP_URL').'/storage', 'visibility' => 'public'],
    's3' => ['driver' => 's3', /* ... */], // stockage cloud, même API
],
```

> 💡 Changer de disque (`local` → `s3` en production, par exemple) ne change **rien** au code applicatif : vous manipulez toujours `Storage::disk('public')->...`. C'est le même principe d'abstraction que PDO (module 02.8), qui permet de changer de moteur de base de données sans réécrire les requêtes.

### Rendre le disque `public` accessible depuis le web

```bash
php artisan storage:link
```

Crée un lien symbolique de `public/storage` vers `storage/app/public` — les fichiers de ce disque deviennent accessibles via une URL, sans exposer directement le dossier `storage/`.

### Uploader un fichier

```php
// Validation
$request->validate([
    'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048', // 2048 Ko max
]);

// Stockage
$chemin = $request->file('image')->store('articles', 'public');
// $chemin ressemble à : "articles/aBcD1234.jpg" (nom généré automatiquement, pas de collision)

Article::create([
    'titre' => $request->input('titre'),
    'image' => $chemin,
]);
```

> ⚠️ **Ne jamais faire confiance au nom de fichier original** envoyé par l'utilisateur (`$request->file('image')->getClientOriginalName()`) pour le stockage réel : il peut contenir des caractères dangereux, ou entrer en collision avec un fichier existant. `store()` génère un nom unique et sûr automatiquement — la même prudence que face à toute donnée utilisateur (module 02.6).

### Afficher un fichier stocké

```php
// app/Models/Article.php
protected function imageUrl(): Attribute
{
    return Attribute::make(
        get: fn () => $this->image ? Storage::disk('public')->url($this->image) : null,
    );
}
```

```blade
@if ($article->image_url)
    <img src="{{ $article->image_url }}" alt="{{ $article->titre }}">
@endif
```

### Remplacer et supprimer un fichier

```php
public function update(Request $request, Article $article)
{
    if ($request->hasFile('image')) {
        // Supprime l'ancien fichier AVANT d'enregistrer le nouveau, pour ne pas
        // accumuler des fichiers orphelins sur le disque au fil des modifications
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->image = $request->file('image')->store('articles', 'public');
    }

    $article->save();
}
```

```php
// Lors de la suppression de l'article lui-même
public function destroy(Article $article)
{
    if ($article->image) {
        Storage::disk('public')->delete($article->image);
    }

    $article->delete();
}
```

> ⚠️ **Piège fréquent** : supprimer un enregistrement en base **sans** supprimer le fichier associé sur le disque laisse des fichiers orphelins qui s'accumulent indéfiniment. Toujours nettoyer le fichier au moment de la suppression/remplacement de l'enregistrement qui le référence.

## ✅ Points clés à retenir

- `Storage::disk('public')` abstrait le stockage physique, changeable (local/S3) sans toucher au code applicatif.
- `php artisan storage:link` rend le disque `public` accessible par une URL web.
- Valider systématiquement type et taille d'un fichier uploadé (`image`, `mimes:`, `max:`).
- Toujours supprimer le fichier physique lors de la suppression/remplacement de l'enregistrement qui le référence, pour éviter les fichiers orphelins.

## ➡️ Pour aller plus loin

- [laravel.com/docs — File Storage](https://laravel.com/docs/filesystem)
- [laravel.com/docs — Validation (File Rules)](https://laravel.com/docs/validation#validating-files)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [07.5 — Policies et Gates](../05-autorisations-policies-gates/README.md) · **Suite :** [07.7 — Notifications et emails](../07-notifications-mail/README.md)
