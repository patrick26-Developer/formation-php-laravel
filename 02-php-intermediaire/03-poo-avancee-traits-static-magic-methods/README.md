# 02.3 — POO avancée : traits, static, méthodes magiques

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Réutiliser du code entre classes non liées avec les traits.
- Comprendre et utiliser les membres statiques (`static`).
- Connaître les méthodes magiques les plus utiles (`__construct`, `__toString`, `__get`, `__set`).
- Utiliser les enums (PHP 8.1+).

## 📋 Prérequis

[02.2 — Héritage, interfaces, abstraction](../02-poo-heritage-interfaces-abstraction/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### Les traits : partager du code sans héritage

PHP ne permet pas l'héritage multiple (une classe ne peut avoir qu'un seul `extends`). Les **traits** permettent d'injecter des méthodes dans plusieurs classes non liées entre elles par héritage.

```php
<?php
declare(strict_types=1);

trait Horodatable {
    private ?DateTimeImmutable $creeLe = null;

    public function initialiserHorodatage(): void {
        $this->creeLe = new DateTimeImmutable();
    }

    public function getDateCreation(): ?DateTimeImmutable {
        return $this->creeLe;
    }
}

class Article {
    use Horodatable;

    public function __construct(private string $titre) {
        $this->initialiserHorodatage();
    }
}

class Commentaire {
    use Horodatable; // Commentaire et Article n'ont aucun lien d'héritage, mais partagent ce comportement

    public function __construct(private string $contenu) {
        $this->initialiserHorodatage();
    }
}
```

> 📌 Laravel utilise énormément les traits (par exemple `HasFactory`, `Notifiable` sur les modèles Eloquent, vus au [niveau 06](../../06-laravel-fondamentaux/README.md)) — comprendre ce mécanisme dès maintenant vous évitera bien des confusions plus tard.

### Membres statiques : partagés par toutes les instances

Une propriété ou méthode `static` appartient à la **classe elle-même**, pas à une instance particulière.

```php
<?php
class CompteurVisites {
    private static int $total = 0;

    public static function incrementer(): void {
        self::$total++;
    }

    public static function getTotal(): int {
        return self::$total;
    }
}

CompteurVisites::incrementer();
CompteurVisites::incrementer();
CompteurVisites::incrementer();

echo CompteurVisites::getTotal(); // 3 -- partagé entre tous les appels, sans instancier la classe
```

`self::` référence la classe courante (utile à l'intérieur de méthodes statiques, où `$this` n'existe pas).

### Le pattern Singleton (un exemple d'usage de `static`)

```php
<?php
class Configuration {
    private static ?Configuration $instance = null;
    private array $parametres = [];

    private function __construct() {
        $this->parametres = ['nom_app' => 'Ma Formation PHP'];
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function get(string $cle): mixed {
        return $this->parametres[$cle] ?? null;
    }
}

$config = Configuration::getInstance();
echo $config->get('nom_app');
```

> 📌 Le Singleton est approfondi comme pattern de conception au [module 03.1](../../03-php-avance/01-design-patterns-php/README.md). Retenez pour l'instant le mécanisme technique : un constructeur `private` empêche `new Configuration()` depuis l'extérieur, forçant à passer par `getInstance()`.

### Méthodes magiques essentielles

Les méthodes magiques commencent par `__` et sont appelées automatiquement par PHP dans certaines situations.

```php
<?php
class Argent {
    public function __construct(private float $montant, private string $devise) {}

    // Appelée automatiquement quand l'objet est utilisé comme une chaîne (echo, concaténation...)
    public function __toString(): string {
        return number_format($this->montant, 2) . " " . $this->devise;
    }
}

$prix = new Argent(19.9, "€");
echo $prix; // 19.90 € -- __toString() est appelée automatiquement
echo "Le prix est : $prix"; // fonctionne aussi en interpolation
```

```php
<?php
class DonneesFlexibles {
    private array $donnees = [];

    // Appelée quand on accède à une propriété inexistante : $objet->propriete
    public function __get(string $nom): mixed {
        return $this->donnees[$nom] ?? null;
    }

    // Appelée quand on assigne une propriété inexistante : $objet->propriete = valeur
    public function __set(string $nom, mixed $valeur): void {
        $this->donnees[$nom] = $valeur;
    }
}

$objet = new DonneesFlexibles();
$objet->couleur = "rouge"; // déclenche __set()
echo $objet->couleur;      // déclenche __get() -- affiche "rouge"
```

> ⚠️ `__get`/`__set` sont puissantes mais à utiliser avec parcimonie : elles rendent le code moins explicite (on ne voit plus directement quelles propriétés existent). Laravel les utilise pour ses modèles Eloquent (accès aux colonnes de base de données comme des propriétés), mais dans votre propre code, préférez des propriétés déclarées explicitement sauf besoin précis.

### Les enums (PHP 8.1+) : un ensemble fixe de valeurs

```php
<?php
enum StatutCommande: string {
    case EnAttente = 'en_attente';
    case Expediee = 'expediee';
    case Livree = 'livree';

    public function libelle(): string {
        return match ($this) {
            self::EnAttente => 'En attente de traitement',
            self::Expediee => 'Colis expédié',
            self::Livree => 'Colis livré',
        };
    }
}

$statut = StatutCommande::Expediee;
echo $statut->value;    // "expediee"
echo $statut->libelle(); // "Colis expédié"
```

> 📌 Les enums remplacent avantageusement les anciennes constantes de classe pour représenter un ensemble fixe et fini de valeurs possibles (statuts, rôles, types...) — très utilisés dans Laravel moderne.

## ✅ Points clés à retenir

- Un trait injecte des méthodes dans des classes sans lien d'héritage (`use NomDuTrait;`).
- `static` définit un membre partagé par la classe entière, accessible via `self::` en interne ou `NomClasse::` depuis l'extérieur.
- `__toString()` permet d'utiliser un objet comme une chaîne de caractères.
- Les enums typés représentent proprement un ensemble fixe de valeurs, avec des méthodes associées.

## ➡️ Pour aller plus loin

- [php.net/manual/fr/language.oop5.traits.php](https://www.php.net/manual/fr/language.oop5.traits.php)
- [php.net/manual/fr/language.oop5.magic.php](https://www.php.net/manual/fr/language.oop5.magic.php)
- [php.net/manual/fr/language.enumerations.php](https://www.php.net/manual/fr/language.enumerations.php)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [02.2 — Héritage, interfaces, abstraction](../02-poo-heritage-interfaces-abstraction/README.md) · **Suite :** [02.4 — Gestion des exceptions](../04-gestion-exceptions/README.md)
