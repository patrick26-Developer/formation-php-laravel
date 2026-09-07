# Foire aux questions

## Généralités

**Dois-je suivre les niveaux dans l'ordre ?**
Oui, pour un premier passage — chaque niveau s'appuie explicitement sur les précédents (voir les encarts "reconnaissez le module X" dans les cours Laravel, qui relient chaque mécanisme à sa version construite à la main en PHP pur). Les [grands projets du niveau 13](../13-grands-projets/README.md) peuvent en revanche être suivis dans l'ordre de votre choix.

**Combien de temps prend la formation en entier ?**
Cela dépend énormément du rythme et du niveau de départ. À titre indicatif, chaque module de cours indique une durée estimée (théorie + exercices) en en-tête — additionnez celles des niveaux qui vous intéressent pour une estimation personnalisée.

**Puis-je sauter directement à Laravel sans faire les niveaux 01 à 05 ?**
Techniquement possible si vous maîtrisez déjà PHP, mais fortement déconseillé : les niveaux 01 à 05 construisent à la main (routeur, ORM simplifié, authentification, API) ce que Laravel automatise ensuite — sans ce socle, Laravel restera une "boîte magique" plutôt qu'un outil compris.

## Environnement et installation

**Dois-je utiliser Docker dès le début ?**
Non. Le [module 00.2](../00-introduction/02-installation-environnement/README.md) recommande une installation locale classique (PHP, Composer, MySQL) pour débuter — Docker est introduit progressivement à partir du [module 05.2](../05-outils-professionnels/02-docker-fondamentaux/README.md), une fois les bases solides.

**Quelle version de PHP/Laravel utiliser ?**
PHP 8.3+ et la dernière version stable de Laravel (11+ au moment de la rédaction). Voir le [module 14.4](../14-preparation-professionnelle/04-veille-et-ecosysteme-php-laravel/README.md) pour vérifier les versions actuellement supportées.

**J'utilise Windows/Mac/Linux, ça change quelque chose ?**
Très peu — PHP, Composer et Laravel fonctionnent de façon quasi identique sur les trois systèmes. Le [module 00.2](../00-introduction/02-installation-environnement/README.md) donne les instructions spécifiques à chacun.

## Contenu et pédagogie

**Pourquoi certains modules n'ont pas d'EXERCICES.md avec du code ?**
Les modules du [Niveau 14](../14-preparation-professionnelle/README.md) sont réflexifs (architecture, entretiens) : leurs exercices produisent des textes de réflexion plutôt que du code exécutable, avec des corrigés indicatifs plutôt que des solutions figées.

**Pourquoi les mini-projets ne fournissent-ils pas un projet Laravel complet à copier-coller ?**
Chaque projet fournit les fichiers **à ajouter** à un projet Laravel fraîchement installé (voir `INSTALLATION.md` de chaque projet) — reconstruire l'installation vous-même fait partie de l'apprentissage (rappel du [module 00.4](../00-introduction/04-methodologie-apprentissage/README.md) sur le "tutorial hell").

**Un module référence un module qui n'existe pas encore dans mon parcours, que faire ?**
Certains renvois pointent volontairement vers un module ultérieur ("approfondi au module X") pour signaler qu'un sujet reviendra plus tard sans qu'il faille s'y attarder immédiatement — poursuivez votre lecture normalement.

## Contribution et licence

**Puis-je utiliser cette formation pour former mon équipe/mes étudiants ?**
Oui — le contenu est sous licence [MIT](../LICENSE), libre d'utilisation, de copie et de modification, y compris à des fins commerciales, sous réserve de conserver la mention de copyright.

**J'ai trouvé une erreur ou une amélioration possible, comment contribuer ?**
Voir [CONTRIBUTING.md](../CONTRIBUTING.md) pour les conventions de contenu et le format attendu.

**La version anglaise n'est pas encore disponible pour tous les modules, pourquoi ?**
Le français est la langue source de cette formation ; la traduction anglaise suit une fois le contenu français stabilisé (voir [ROADMAP.md](../ROADMAP.md) pour l'avancement).
