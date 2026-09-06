# Exercices — 07.7 Notifications et envoi d'emails

## Exercice 1 — Premier Mailable (facile)

Créez un `BienvenueMail` envoyé à l'inscription (surchargez ou étendez le flux Breeze). Configurez `MAIL_MAILER=log` et vérifiez le contenu dans `storage/logs/laravel.log`.

## Exercice 2 — Notification par email (facile)

Créez une notification `ArticlePublieNotification` envoyée à un utilisateur quand un article est publié, avec `via()` retournant `['mail']` uniquement.

## Exercice 3 — Notification multi-canal (moyen)

Modifiez la notification de l'exercice 2 pour aussi la stocker en base (`via() => ['mail', 'database']`). Migrez la table de notifications et vérifiez son contenu après un envoi.

## Exercice 4 — Centre de notifications (moyen)

Affichez dans le layout un compteur de notifications non lues (`auth()->user()->unreadNotifications->count()`) et une liste déroulante les listant. Ajoutez un bouton "Tout marquer comme lu" (`markAsRead()`).

## Exercice 5 — Notification sur nouveau commentaire (difficile)

Sur le [mini-projet du niveau 06](../../06-laravel-fondamentaux/projet-mini-03-blog-crud-laravel/README.md), déclenchez une `NouveauCommentaireNotification` vers l'auteur de l'article dès qu'un commentaire est publié (dans `CommentController::store()`). Gérez le cas où l'article n'a pas d'auteur (avant l'exercice 5 du module 07.4) sans erreur.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
