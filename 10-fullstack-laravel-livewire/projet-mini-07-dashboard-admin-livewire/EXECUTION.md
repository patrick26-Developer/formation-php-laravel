# Exécution

## Lancer les tests

```bash
php artisan test --filter=AnnoncesTableTest
```

## Lancer l'application

```bash
php artisan serve
```

Connectez-vous avec le compte promu administrateur à l'installation, puis ouvrez `http://localhost:8000/admin`.

## Utiliser le dashboard

- **Rechercher** un titre : les résultats se filtrent après une courte pause (300ms), sans rechargement de page.
- **Filtrer** par catégorie ou statut : mise à jour instantanée.
- **Trier** en cliquant sur "Titre" ou "Prix" : la flèche indique la colonne et le sens actifs.
- **Activer/Désactiver** une annonce : le statut change immédiatement dans le tableau, **et** le widget de statistiques en haut de page se met à jour tout seul.
- **Supprimer** : une boîte de confirmation JavaScript (Alpine, aucune requête serveur) apparaît d'abord ; seul un clic sur "OK" déclenche réellement la suppression côté serveur.

## Vérifier la persistance de l'état dans l'URL

Effectuez une recherche, changez de page, puis rafraîchissez complètement la page (F5) : la recherche, le tri et le numéro de page doivent être conservés — visible directement dans l'URL (`?recherche=...&tri=...&page=...`).

## Vérifier la communication entre composants

Ouvrez les outils réseau du navigateur. Cliquez sur "Désactiver" pour une annonce : une seule requête Livewire part vers le serveur, mais **deux zones de la page** se mettent à jour dans la réponse (la ligne du tableau et le widget de statistiques) — la preuve que l'événement `statistiques-modifiees` a bien notifié le second composant.

**Voir aussi :** [JOURNAL.md](JOURNAL.md) pour la démarche de construction complète.
