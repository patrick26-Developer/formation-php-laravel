# Exercices — 02.5 Sessions, cookies, authentification maison

> Lancez ces exercices avec `php -S localhost:8000` et testez dans un navigateur — les sessions nécessitent de vraies requêtes HTTP.

## Exercice 1 — Compteur de visites en session (facile)

Créez une page qui compte et affiche le nombre de fois où elle a été visitée, en utilisant `$_SESSION`. Rechargez la page plusieurs fois pour vérifier.

## Exercice 2 — Préférence en cookie (facile)

Créez un formulaire permettant de choisir un thème ("clair"/"sombre"), stocké dans un cookie valable 7 jours. Affichez le thème actif en lisant `$_COOKIE`.

## Exercice 3 — Hachage de mot de passe (moyen)

Écrivez un script qui hache un mot de passe saisi via un formulaire avec `password_hash()`, affiche le hash obtenu, puis vérifie via un second formulaire si un mot de passe saisi correspond à ce hash avec `password_verify()`.

## Exercice 4 — Connexion complète (moyen)

En reprenant l'exemple du cours (annuaire simulé en tableau PHP), construisez un flux complet : formulaire de connexion → vérification → session → redirection vers une page protégée qui affiche l'email connecté → lien de déconnexion qui détruit la session.

## Exercice 5 — Middleware maison réutilisable (difficile)

Créez un fichier `exiger-connexion.php` contenant une fonction `exigerConnexion(): void` qui vérifie `$_SESSION['utilisateur_email']` et redirige vers `connexion.php` si absent. Utilisez cette fonction (via `require_once` + appel) au début de **deux pages protégées différentes**, pour montrer sa réutilisabilité.

---

Comparez avec [solutions/](solutions/) une fois terminé.
