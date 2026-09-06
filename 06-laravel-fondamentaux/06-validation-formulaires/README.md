# 06.6 — Validation des formulaires

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Valider des données entrantes avec les règles de validation Laravel.
- Comprendre le flux automatique de redirection avec erreurs.
- Utiliser les Form Requests pour extraire la validation des contrôleurs.
- Connaître les règles de validation les plus utilisées.

## 📋 Prérequis

[06.5 — Migrations, seeders, factories](../05-migrations-seeders-factories/README.md), [01.7 — Formulaires HTML et GET/POST](../../01-php-fondamentaux/07-formulaires-http-get-post/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### Valider directement dans le contrôleur

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'titre' => 'required|string|max:150',
        'email' => 'required|email',
        'age' => 'required|integer|min:18|max:120',
    ]);

    Tache::create($validated);

    return redirect()->route('taches.index');
}
```

> 💡 Reconnaissez le [module 01.7](../../01-php-fondamentaux/07-formulaires-http-get-post/README.md) : vous vérifiiez manuellement `trim($_POST['titre']) === ''`, `filter_var($email, FILTER_VALIDATE_EMAIL)`, l'intervalle d'un âge. Laravel exprime les mêmes règles de façon déclarative, en une ligne par champ.

**Si la validation échoue**, Laravel redirige **automatiquement** vers la page précédente, avec :
- Les erreurs disponibles via `$errors` dans la vue (utilisées par `@error`, module 06.3).
- Les anciennes valeurs saisies disponibles via `old('champ')`.

**Vous n'écrivez aucun code pour gérer cet échec** — contrairement au flux manuel `$erreurs = []; if (...) { $erreurs[] = ...; }` du module 01.7, entièrement automatisé ici.

### Règles de validation courantes

| Règle | Effet |
|---|---|
| `required` | Le champ doit être présent et non vide |
| `string` / `integer` / `numeric` / `boolean` | Vérifie le type |
| `email` | Format d'email valide (équivalent à `filter_var(..., FILTER_VALIDATE_EMAIL)`) |
| `min:x` / `max:x` | Longueur (chaînes) ou valeur (nombres) minimale/maximale |
| `unique:table,colonne` | La valeur ne doit exister nulle part ailleurs dans cette colonne |
| `exists:table,colonne` | La valeur doit exister dans cette table (utile pour un `categorie_id` par exemple) |
| `confirmed` | Exige un champ `xxx_confirmation` identique (mot de passe) |
| `nullable` | Le champ peut être absent/vide sans déclencher `required` |
| `date` | Doit être une date valide |
| `in:a,b,c` | La valeur doit être l'une de celles listées |

```php
$request->validate([
    'email' => 'required|email|unique:users,email',
    'mot_de_passe' => 'required|min:8|confirmed',
    'statut' => 'required|in:en_attente,expediee,livree',
]);
```

### Messages d'erreur personnalisés

```php
$request->validate(
    [
        'titre' => 'required|max:150',
    ],
    [
        'titre.required' => 'Le titre de la tâche est obligatoire.',
        'titre.max' => 'Le titre ne peut pas dépasser :max caractères.',
    ]
);
```

### Form Requests : extraire la validation du contrôleur

Pour des règles de validation complexes ou réutilisées, Laravel recommande une classe dédiée plutôt que de surcharger le contrôleur.

```bash
php artisan make:request StoreTacheRequest
```

```php
// app/Http/Requests/StoreTacheRequest.php
class StoreTacheRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ou une vérification d'autorisation (module 07.5)
    }

    public function rules(): array
    {
        return [
            'titre' => 'required|string|max:150',
            'description' => 'nullable|string',
        ];
    }
}
```

```php
// Le contrôleur devient très court : Laravel valide AVANT même d'exécuter store()
public function store(StoreTacheRequest $request)
{
    Tache::create($request->validated());
    return redirect()->route('taches.index');
}
```

> 📌 **Bonne pratique professionnelle** : dès qu'un formulaire dépasse 3-4 règles ou que sa validation est réutilisée (création **et** modification), extrayez-la dans un Form Request. Cela respecte le principe de responsabilité unique (module 03.5) : le contrôleur orchestre, le Form Request valide.

## ✅ Points clés à retenir

- `$request->validate([...])` échoue automatiquement avec redirection, erreurs et anciennes valeurs — sans code manuel.
- Les règles combinent type, présence, longueur, unicité, existence en base, etc., via une syntaxe déclarative.
- Un Form Request extrait la validation du contrôleur pour les cas non triviaux, respectant le principe de responsabilité unique.
- Cette automatisation remplace directement le flux manuel du module 01.7, tout en restant tout aussi rigoureuse.

## ➡️ Pour aller plus loin

- [laravel.com/docs — Validation](https://laravel.com/docs/validation)
- [Module 07.3 — Middlewares et Form Requests](../../07-laravel-intermediaire/03-middlewares-form-requests/README.md)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [06.5 — Migrations, seeders, factories](../05-migrations-seeders-factories/README.md) · **Suite :** [06.7 — CRUD complet Laravel](../07-crud-complet-laravel-tri-filtre-recherche/README.md)
