# 14.2 — Code review et refactoring

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Relire du code avec une grille de lecture méthodique plutôt qu'impressionniste.
- Formuler un commentaire de review constructif et actionnable.
- Refactoriser du code existant sans en casser le comportement.
- Utiliser les tests comme filet de sécurité pendant un refactoring.

## 📋 Prérequis

[14.1 — Bonnes pratiques d'architecture logicielle](../01-bonnes-pratiques-architecture-logicielle/README.md), [08.3 — Tests Pest et PHPUnit](../../08-laravel-avance/03-tests-pest-phpunit-laravel/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### Une grille de lecture pour une revue de code

Relire du code au hasard, ligne par ligne, sans méthode, mène à des reviews inégales (parfois trop superficielles, parfois obsédées par des détails de style sans importance). Une grille de lecture en couches aide à rester systématique :

1. **Correction** : le code fait-il ce qu'il prétend faire ? Gère-t-il les cas limites (module 02.4, 01.9) ?
2. **Sécurité** : validation des entrées (module 02.6), autorisation (module 07.5), pas de données sensibles journalisées (module 11.5) ?
3. **Lisibilité** : un développeur qui découvre ce code peut-il le comprendre sans avoir à demander son auteur ?
4. **Cohérence** : respecte-t-il les conventions déjà établies dans le projet (module 03.5) ?
5. **Performance** : problème N+1 (module 03.6/07.1) ? Requête dans une boucle ?
6. **Tests** : le comportement nouveau/modifié est-il couvert (module 08.3) ?

> 📌 Cet ordre est volontaire : la correction et la sécurité priment toujours sur le style. Un commentaire "il manque un point-virgule" sur une PR qui contient une faille d'autorisation est une review qui a raté l'essentiel.

### Formuler un commentaire constructif

```markdown
❌ "Ce code est mal fait."
❌ "Pourquoi tu n'utilises pas un Service ici ?"

✅ "Cette méthode `store()` fait 45 lignes et mélange validation, logique
   métier et envoi d'email. Je propose d'extraire l'envoi d'email dans un
   Job (module 08.1) : ça découplerait la réponse HTTP du succès de
   l'envoi, et ça se testerait plus facilement avec Queue::fake()."

✅ "Question : que se passe-t-il si $request->user()->tenant est null ici
   (utilisateur sans tenant assigné) ? Je ne vois pas de garde contre ce
   cas — un `TypeError` semble possible en l'état."
```

> 💡 Un bon commentaire de review : (1) décrit un fait observable, pas un jugement de personne ; (2) explique le **pourquoi** du problème (impact réel) ; (3) propose une piste concrète, sans forcément l'imposer comme la seule solution valable. Poser une question ("que se passe-t-il si...") est souvent plus efficace qu'une affirmation, surtout quand on n'est pas sûr à 100% qu'il y a un vrai problème.

### Refactoriser en sécurité : les tests d'abord

```
1. Un test qui échoue doit d'abord ÉCHOUER pour la bonne raison
   (si vous corrigez un bug : écrivez le test AVANT le correctif,
   vérifiez qu'il échoue, PUIS corrigez).
2. Un refactoring (changer la structure SANS changer le comportement)
   doit partir d'une suite de tests déjà VERTE.
3. À chaque étape du refactoring, relancer les tests.
4. Ne JAMAIS mélanger refactoring et changement de comportement dans
   le même commit — cela rend impossible d'identifier quelle
   modification a introduit une régression si un test casse.
```

> ⚠️ Refactoriser du code **sans filet de tests** est un pari risqué : impossible de savoir avec certitude si le comportement a été préservé. Sur du code legacy sans tests, la première étape d'un refactoring sérieux consiste souvent à **écrire des tests de caractérisation** (qui documentent le comportement ACTUEL, même imparfait) avant de toucher au code.

### Un exemple de refactoring guidé par les tests

```php
// AVANT : logique dupliquée, difficile à tester isolément
public function index(Request $request)
{
    $annonces = Annonce::where('active', true);
    if ($request->recherche) {
        $annonces = $annonces->where('titre', 'like', '%' . $request->recherche . '%');
    }
    // ... 15 lignes de plus de filtres similaires ...
    return view('annonces.index', ['annonces' => $annonces->paginate(10)]);
}
```

```php
// APRÈS : extraction d'un scope (module 07.2), testable indépendamment
// du contrôleur, sans dépendre d'une requête HTTP simulée
public function scopeFiltrees($query, array $filtres)
{
    return $query
        ->when($filtres['recherche'] ?? null, fn ($q, $v) => $q->where('titre', 'like', "%$v%"))
        ->when($filtres['categorie'] ?? null, fn ($q, $v) => $q->where('categorie_id', $v));
}

public function index(Request $request)
{
    $annonces = Annonce::actives()->filtrees($request->only(['recherche', 'categorie']))->paginate(10);
    return view('annonces.index', compact('annonces'));
}
```

## ✅ Points clés à retenir

- Une grille de lecture (correction → sécurité → lisibilité → cohérence → performance → tests) évite les reviews inégales.
- Un commentaire de review constructif décrit un fait, explique l'impact, propose une piste — sans juger la personne.
- Refactoriser exige une suite de tests verte au départ ; sur du code sans test, écrire d'abord des tests de caractérisation.
- Ne jamais mélanger refactoring et changement de comportement dans le même commit.

## ➡️ Pour aller plus loin

- *Refactoring*, Martin Fowler
- [google.github.io/eng-practices/review](https://google.github.io/eng-practices/review/) (guide de code review de Google, public)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [14.1 — Bonnes pratiques d'architecture](../01-bonnes-pratiques-architecture-logicielle/README.md) · **Suite :** [14.3 — Préparation aux entretiens techniques](../03-preparation-entretiens-techniques/README.md)
