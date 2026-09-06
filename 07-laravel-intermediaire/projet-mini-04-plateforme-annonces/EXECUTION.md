# Exécution

## Lancer l'application

```bash
php artisan serve
```

Ouvrez `http://localhost:8000`.

## Compte de test

Récupérez un email d'utilisateur généré via Tinker :
```bash
php artisan tinker
>>> \App\Models\User::first()->email
```
Mot de passe par défaut des factories Breeze : `password`.

## Utiliser la plateforme

- **Parcourir/rechercher/filtrer/trier** les annonces (public, sans connexion).
- **Contacter un vendeur** via le formulaire en bas d'une annonce (public) — déclenche une notification au vendeur.
- **Se connecter** puis **déposer une annonce** avec photo.
- **Modifier/supprimer** une annonce : uniquement visible et autorisé pour son propriétaire (`AnnoncePolicy`).
- **Ajouter/retirer des favoris** (bouton étoile sur une annonce, connecté uniquement).

## Vérifier l'autorisation (Policy)

Connectez-vous avec un utilisateur A, notez l'URL de modification d'une annonce qui ne lui appartient pas (`/annonces/{id}/modifier`). Déconnectez-vous, connectez-vous avec un utilisateur B différent, et accédez directement à cette URL : Laravel doit répondre **403 Forbidden**, sans qu'aucun lien "Modifier" ne soit même visible pour B sur cette annonce (`@can` dans la vue).

## Vérifier la notification

Envoyez un message de contact sur une annonce. Consultez `storage/logs/laravel.log` (avec `MAIL_MAILER=log`) pour voir l'email généré, puis connectez-vous en tant que propriétaire de cette annonce et vérifiez le compteur de notifications dans le menu.

## Vérifier le nettoyage de fichier

Notez le nom du fichier stocké pour l'image d'une annonce (`storage/app/public/annonces/...`). Supprimez l'annonce depuis l'interface. Vérifiez que le fichier a bien disparu du disque (Model Event `deleting`, module 07.6).

**Voir aussi :** [JOURNAL.md](JOURNAL.md) pour la démarche de construction complète.
