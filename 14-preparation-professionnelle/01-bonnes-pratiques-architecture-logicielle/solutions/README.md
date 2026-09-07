# Corrigé indicatif — 14.1 Bonnes pratiques d'architecture logicielle

## Exercice 1

- (a) Responsabilité unique / Ouvert-Fermé : la règle d'autorisation est centralisée, extensible sans modifier les appelants.
- (b) Responsabilité unique appliquée à l'échelle des méthodes privées d'une classe.
- (c) Ce n'est pas un principe SOLID à proprement parler, mais une application du principe de performance proportionnée (ne pas refaire un travail coûteux déjà fait récemment).

## Exercice 2

Responsabilités mélangées : accès aux données (requêtes SQL directes), présentation (formatage), génération de document (Dompdf), notification (email). Décomposition proposée : un `Invoice` (modèle/requête via Eloquent plutôt que SQL brut), un `InvoicePdfGenerator` (génération), un `InvoiceMailer` ou une Notification (envoi) — le contrôleur devient un simple orchestrateur de quelques lignes appelant ces trois services.

## Exercice 3

"Je comprends l'envie de bien faire, mais regardons ce que chaque couche ajoutée résout concrètement ici : le Repository protégerait contre un changement d'ORM — improbable et non demandé ; l'interface permettrait de mocker en test — mais Eloquent se teste très bien directement avec `RefreshDatabase` ; la Factory créerait des objets — mais `Product::create()` suffit. Chaque couche a un coût (fichiers en plus, indirection à suivre en lecture de code) qui doit être justifié par un besoin réel. Gardons cette architecture pour le jour où un vrai signal apparaît — dupliquer une même vérification dans 4 endroits, par exemple — et restons simples aujourd'hui."

## Exercice 4

"Dans le tunnel d'achat e-commerce, un paiement refusé signifie que la transaction n'a tout simplement jamais eu lieu : il est cohérent d'annuler la commande et de restaurer le stock, comme si rien ne s'était passé. Pour un abonnement SaaS, la situation est différente : le service a déjà été rendu pendant la période écoulée, l'obligation de paiement du client existe indépendamment du succès de la tentative de prélèvement. Annuler la facture ferait disparaître cette trace, empêchant toute relance ou action de recouvrement ultérieure. Le risque de ne pas le faire : un client dont la carte a expiré continuerait indéfiniment à utiliser le service sans qu'aucune facture n'existe jamais pour documenter l'impayé."

## Exercice 5

Signaux PRÉSENTS et justifiant une évolution :
- 6 développeurs sur le même code → risque de conflits fréquents sur les mêmes fichiers si tout reste dans `app/Http/Controllers/` à plat.
- 200 000 annonces → potentiel besoin d'optimisation de requêtes (module 04.3, index, pagination par curseur plutôt que offset).

Signaux ABSENTS ne justifiant PAS encore une architecture par domaine complète :
- 50 catégories seule ne crée pas un nombre de fichiers ingérable.
- Rien n'indique un besoin de changer de base de données ou d'ORM (pas de raison d'introduire un Repository abstrait).

Plan en 3 étapes, par impact/risque :
1. (Impact fort, risque faible) Auditer et ajouter les index manquants (module 04.3) sur les colonnes de recherche/tri fréquentes.
2. (Impact moyen, risque faible) Passer les listes volumineuses à une pagination par curseur si des lenteurs sont mesurées au-delà de la page ~50.
3. (Impact fort, risque plus élevé — à ne déclencher QUE si la navigation devient réellement pénible) Réorganiser progressivement par domaine (module 08.5), un domaine à la fois, sans big-bang.
