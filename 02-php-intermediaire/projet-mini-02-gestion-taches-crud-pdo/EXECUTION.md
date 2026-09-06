# Exécution

## Lancer l'application

Le point d'entrée web se trouve dans `public/`. Lancez le serveur PHP intégré **depuis ce dossier** :

```bash
cd public
php -S localhost:8000
```

Puis ouvrez `http://localhost:8000/connexion.php` dans votre navigateur.

## Se connecter

Utilisez le compte créé par `php src/seed.php` (voir [INSTALLATION.md](INSTALLATION.md)) :

- Email : `demo@example.com`
- Mot de passe : `demo1234`

## Utiliser l'application

- **Créer une tâche** : bouton "+ Nouvelle tâche" depuis la liste.
- **Trier** : cliquez sur les en-têtes de colonne "Titre", "Statut" ou "Créée le" — un second clic inverse l'ordre.
- **Rechercher** : tapez un terme dans le champ de recherche (filtre sur le titre).
- **Filtrer par statut** : menu déroulant "Toutes / En cours / Terminées".
- **Paginer** : liens de numéro de page en bas de liste (5 tâches par page).
- **Modifier/Supprimer** : liens dans la colonne "Actions" de chaque ligne.
- **Se déconnecter** : lien en haut de la page — détruit la session.

## Tester l'isolation entre utilisateurs

Créez un second utilisateur directement en base (ou adaptez `seed.php`), connectez-vous avec, et vérifiez qu'il ne voit **aucune** des tâches créées par `demo@example.com` — c'est le comportement attendu de `TacheRepository`, qui filtre systématiquement par `utilisateur_id`.

## Tester la protection CSRF

Depuis les outils de développement du navigateur, retirez le champ caché `jeton_csrf` d'un formulaire (création, modification ou suppression) avant de le soumettre : le serveur doit répondre "403 Requête refusée".

**Voir aussi :** [JOURNAL.md](JOURNAL.md) pour comprendre comment cette protection a été mise en place.
