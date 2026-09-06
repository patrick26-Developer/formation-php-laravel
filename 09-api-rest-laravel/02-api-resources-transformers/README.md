# 09.2 — API Resources et transformation des données

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Structurer les réponses JSON avec les API Resources.
- Transformer et masquer sélectivement des champs.
- Gérer les relations dans une Resource sans provoquer de problème N+1.
- Structurer les réponses de validation automatiques.

## 📋 Prérequis

[09.1 — Conception d'API RESTful](../01-conception-api-restful-bonnes-pratiques/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### Le problème : exposer directement un modèle Eloquent en JSON

```php
public function show(Annonce $annonce)
{
    return $annonce; // toutes les colonnes exposées telles quelles, sans contrôle
}
```

> ⚠️ Retourner un modèle Eloquent directement expose **toutes** ses colonnes (y compris, potentiellement, des informations internes non destinées au client), et lie la structure de la réponse JSON à la structure de la table en base — un changement de nom de colonne casserait alors l'API pour tous ses clients.

### Créer une API Resource

```bash
php artisan make:resource AnnonceResource
```

```php
// app/Http/Resources/AnnonceResource.php
class AnnonceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'prix' => (float) $this->prix,
            'image_url' => $this->image_url, // utilise l'accessor du module 07.2
            'categorie' => $this->whenLoaded('categorie', fn () => [
                'id' => $this->categorie->id,
                'nom' => $this->categorie->nom,
            ]),
            'cree_le' => $this->created_at->toIso8601String(),
        ];
    }
}
```

```php
public function show(Annonce $annonce)
{
    return new AnnonceResource($annonce->load('categorie'));
}

public function index()
{
    return AnnonceResource::collection(Annonce::with('categorie')->paginate(15));
}
```

> 💡 Une Resource découple **totalement** la structure de la réponse JSON de la structure de la table SQL : renommer une colonne en base ne casse rien côté client tant que la Resource continue d'exposer le même nom de champ JSON — le même principe d'abstraction que Storage (module 07.6) ou PDO (module 02.8).

### `whenLoaded()` : éviter le problème N+1 dans une Resource

```php
'categorie' => $this->whenLoaded('categorie', fn () => new CategoryResource($this->categorie)),
```

> ⚠️ `whenLoaded()` n'inclut la relation dans la réponse **que si elle a déjà été chargée** (via `with()`, module 07.1) sur la requête d'origine. Sans cette précaution, accéder à `$this->categorie` dans une Resource déclencherait une requête SQL **par annonce** affichée — le problème N+1, cette fois caché dans la couche de transformation plutôt que dans un contrôleur ou une vue.

### Resource Collections et métadonnées

```php
class AnnonceCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'total' => $this->collection->count(),
            ],
        ];
    }
}
```

Avec `paginate()` (module 06.7), Laravel enrichit **automatiquement** la réponse d'une collection de Resources avec des métadonnées de pagination (`links`, `meta.current_page`, `meta.total`...) — aucun code supplémentaire nécessaire.

### Les erreurs de validation en API : automatiquement au format JSON

```php
class StoreAnnonceRequest extends FormRequest
{
    // ... rules() ...
}
```

Pour une requête envoyée avec l'en-tête `Accept: application/json`, un échec de validation (module 06.6) retourne **automatiquement** :

```json
{
    "message": "The titre field is required.",
    "errors": {
        "titre": ["The titre field is required."]
    }
}
```

> 📌 C'est le même Form Request que pour une route web (`routes/web.php`) — Laravel adapte **automatiquement** le format de la réponse d'erreur (redirection HTML vs JSON structuré) selon l'en-tête `Accept` de la requête entrante. Aucune duplication de règles de validation entre web et API.

## ✅ Points clés à retenir

- Une API Resource découple la structure JSON exposée de la structure de la table SQL.
- `whenLoaded()` évite d'introduire un problème N+1 caché dans la transformation d'une relation.
- La pagination Eloquent enrichit automatiquement une Resource Collection de métadonnées.
- Les erreurs de validation d'un Form Request sont automatiquement formatées en JSON structuré pour une requête API.

## ➡️ Pour aller plus loin

- [laravel.com/docs — Eloquent: API Resources](https://laravel.com/docs/eloquent-resources)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [09.1 — Conception d'API RESTful](../01-conception-api-restful-bonnes-pratiques/README.md) · **Suite :** [09.3 — Authentification API avec Sanctum](../03-authentification-api-sanctum/README.md)
