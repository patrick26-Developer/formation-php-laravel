# Journal de construction

## Étape 1 — Le panier en session, jamais en base

Décision structurante : `CartService` ne touche à AUCUNE table. Un visiteur non connecté doit pouvoir composer son panier librement — imposer un compte dès le premier ajout serait une friction inutile, et aurait exigé de gérer des paniers "orphelins" en base pour des visiteurs jamais revenus. Le [module 02.5](../../02-php-intermediaire/05-sessions-cookies-authentification-maison/README.md) fournit exactement le mécanisme adapté à cette donnée éphémère et propre à un visiteur.

## Étape 2 — Le schéma : dénormalisation assumée sur `order_items`

`order_items.nom_produit` et `prix_unitaire` DUPLIQUENT des informations déjà présentes sur `products`. C'est une dénormalisation **volontaire** (rappel du [module 04.1](../../04-bases-de-donnees-approfondi/01-modelisation-relationnelle-mcd-mld/README.md) sur les compromis de modélisation) : une commande doit rester un **document historique fidèle**, immuable, même si le produit est ensuite renommé, voit son prix changer, ou est supprimé (`restrictOnDelete()` sur `product_id` empêche d'ailleurs cette suppression tant qu'une commande y fait référence — mais le nom/prix restent de toute façon préservés indépendamment).

## Étape 3 — `OrderService::passerCommande()`, le cœur du projet

Toute la logique de commande est encapsulée dans **une seule transaction** (`DB::transaction()`, module 04.2) : vérification du stock, création de la commande, création des lignes, décrémentation du stock (`decrement()`, une opération atomique côté SQL), puis appel au paiement. Si **n'importe laquelle** de ces étapes échoue (stock insuffisant, paiement refusé), Laravel annule automatiquement tout ce qui a été fait dans cette transaction — aucune commande "à moitié créée", aucun stock décrémenté sans commande valide en face.

## Étape 4 — `PaymentGateway`, une interface avant tout

`FakePaymentGateway` n'est PAS une simplification honteuse : c'est une implémentation **complète** d'une interface (`PaymentGateway`) pensée dès le départ pour être remplaçable (module 08.4). Passer à un vrai prestataire (Stripe, par exemple) en production ne changerait qu'une ligne dans `AppServiceProvider::register()` — `OrderService`, les contrôleurs, et les tests resteraient identiques.

## Étape 5 — Tester le rollback, pas seulement le succès

`CheckoutTest` consacre volontairement plus de la moitié de ses tests aux cas d'échec (stock insuffisant, paiement refusé), pas seulement au chemin heureux. Le test du rollback lie une fausse passerelle **spécifique au test** (`$this->app->bind(...)`, réutilisant le mécanisme d'injection du module 08.4) qui échoue systématiquement, pour prouver — sans ambiguïté — que le stock et la commande reviennent à leur état d'origine après l'échec.

## Pour aller plus loin (hors scope de ce projet)

Aucune gestion de coupon de réduction, de frais de livraison, ni de variantes de produit (taille, couleur) — le catalogue reste volontairement à plat. L'admin ne couvre que les produits (pas la gestion des commandes ni des catégories), laissé en exercice libre sur le modèle du contrôleur `Admin\ProductController` déjà fourni.
