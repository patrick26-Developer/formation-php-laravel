# Exercices — 07.6 Upload de fichiers et Storage

## Exercice 1 — Premier upload (facile)

Ajoutez une colonne `image` (nullable) à `articles`. Ajoutez un champ fichier au formulaire de création, validez-le (`image|mimes:jpg,png|max:2048`), stockez-le sur le disque `public`.

## Exercice 2 — Afficher l'image (facile)

Ajoutez un accessor `imageUrl` et affichez l'image sur la page de l'article (avec une image par défaut si absente).

## Exercice 3 — Remplacer une image (moyen)

Sur le formulaire de modification, permettez de changer l'image. Supprimez l'ancienne du disque avant de stocker la nouvelle.

## Exercice 4 — Validation stricte (moyen)

Ajoutez `dimensions:min_width=300,min_height=200` à la validation, pour rejeter des images trop petites. Testez avec une image non conforme et vérifiez le message d'erreur.

## Exercice 5 — Nettoyage à la suppression (difficile)

Utilisez un **Model Event** (`deleting`, dans `booted()` du modèle `Article`) plutôt qu'une ligne dans le contrôleur, pour supprimer automatiquement le fichier image dès qu'un article est supprimé, **peu importe d'où vient la suppression** (contrôleur, Tinker, commande Artisan...). Expliquez en commentaire l'avantage de cette approche par rapport à une suppression codée uniquement dans `destroy()`.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
