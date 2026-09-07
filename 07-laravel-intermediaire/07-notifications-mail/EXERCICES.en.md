# Exercises — 07.7 Notifications and Sending Emails

## Exercise 1 — First Mailable (easy)

Create a `BienvenueMail` sent on registration (override or extend the Breeze flow). Configure `MAIL_MAILER=log` and check the content in `storage/logs/laravel.log`.

## Exercise 2 — Email notification (easy)

Create an `ArticlePublieNotification` notification sent to a user when an article is published, with `via()` returning `['mail']` only.

## Exercise 3 — Multi-channel notification (medium)

Modify exercise 2's notification to also store it in the database (`via() => ['mail', 'database']`). Migrate the notifications table and check its content after sending.

## Exercise 4 — Notification center (medium)

Display in the layout a count of unread notifications (`auth()->user()->unreadNotifications->count()`) and a dropdown listing them. Add a "Mark all as read" button (`markAsRead()`).

## Exercise 5 — Notification on a new comment (hard)

On the [level 06 mini-project](../../06-laravel-fondamentaux/projet-mini-03-blog-crud-laravel/README.en.md), trigger a `NouveauCommentaireNotification` to the article's author as soon as a comment is published (in `CommentController::store()`). Handle the case where the article has no author (before module 07.4's exercise 5) without error.

---

See [solutions/README.md](solutions/README.md) for the answer key.
