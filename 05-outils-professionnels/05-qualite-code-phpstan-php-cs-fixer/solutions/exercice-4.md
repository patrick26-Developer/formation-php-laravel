# Solution — Exercice 4

```bash
cd grand-projet-01-mini-framework-mvc-avec-api
composer require --dev phpstan/phpstan

# Niveau 0 : vérifications basiques (variables inconnues, appels à des
# fonctions/classes inexistantes) — attendu : 0 ou très peu d'erreurs,
# le code du grand projet étant déjà propre.
./vendor/bin/phpstan analyse src --level 0

# Niveau 3 : ajoute la vérification des types de retour déclarés, des
# propriétés non initialisées — attendu : toujours peu ou pas d'erreurs,
# car le projet type déjà systématiquement (déclare(strict_types=1) partout).

# Niveau 6 : exige que TOUS les paramètres et types de retour soient
# explicitement déclarés (pas de type implicite "mixed" toléré sans le dire).
./vendor/bin/phpstan analyse src --level 6
# Erreur typique possible : une méthode de Vue::afficher() avec un tableau
# $donnees sans précision de son contenu (PHPDoc @param array<string, mixed>
# manquant) — PHPStan peut le signaler comme imprécision de type à ce niveau.

# Niveau 8 : le plus strict pour un usage courant — vérifie même l'absence
# de vérification explicite avant d'accéder à une valeur potentiellement null.
./vendor/bin/phpstan analyse src --level 8
# Erreur typique : dans TacheApiController::modifier(), l'accès à
# $tache['titre'] après un premier appel à trouver() qui pourrait avoir
# retourné null (même si un contrôle a déjà été fait juste avant, PHPStan
# ne peut pas toujours "suivre" cette logique selon comment elle est écrite).

# Correction possible d'une erreur de niveau 6+ : ajouter une annotation
# PHPDoc précisant la forme du tableau retourné par TacheRepository::trouver() :
#
# /**
#  * @return array{id: int, titre: string, description: ?string, terminee: int, creee_le: string}|null
#  */
# public function trouver(int $id): ?array
```

Constat général : plus un projet type strictement dès le départ
(`declare(strict_types=1)`, constructeurs promus typés, retours explicites —
toutes des pratiques déjà appliquées dans ce grand projet), moins l'écart
entre les niveaux bas et hauts de PHPStan est important. C'est la preuve
concrète que les bonnes pratiques du module 03.5 payent directement en
qualité mesurable.
