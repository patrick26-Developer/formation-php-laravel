# Journal de construction

## Étape 1 — Pourquoi une dépendance Composer plutôt que du PHP pur

PHP ne sait pas générer de PDF nativement. Plutôt que de réinventer un format binaire complexe, `dompdf/dompdf` convertit du HTML/CSS en PDF — une approche qui permet de réutiliser des compétences déjà acquises (module 01.7 : écrire du HTML) pour un besoin totalement différent. `isRemoteEnabled: false` est activé volontairement : ce générateur ne doit jamais charger d'images ou de ressources distantes, une source classique de vulnérabilité (SSRF) si le contenu HTML provenait un jour d'une source non fiable.

## Étape 2 — Une seule classe, une seule responsabilité

`RapportGenerator` a une seule méthode publique (`genererDepuisCsv`) ; `lireCsv`, `construireHtml`, `convertirEnPdf` sont privées et forment les étapes internes du pipeline. Cette structure suit directement le principe de responsabilité unique du [module 03.5](../../03-php-avance/05-bonnes-pratiques-psr-clean-code/README.md) : chaque méthode privée peut être relue et comprise indépendamment des autres.

## Étape 3 — L'échappement HTML, même en contexte "interne"

Chaque valeur du CSV est passée par `htmlspecialchars()` avant d'être insérée dans le HTML transmis à Dompdf. Ce n'est pas un contexte web classique exposé à un attaquant externe, mais si le CSV provient un jour d'un import utilisateur (une évolution plausible de cet outil), l'absence de cette protection ouvrirait une injection HTML dans le rapport généré — la même vigilance que le [module 02.6](../../02-php-intermediaire/06-securite-web-fondamentaux/README.md), appliquée par réflexe même hors d'un navigateur.

## Étape 4 — Tester un fichier binaire sans comparer son contenu exact

`RapportGeneratorTest` ne compare pas le PDF généré à un fichier de référence (fragile : la moindre différence de version de Dompdf changerait le binaire produit). Il vérifie plutôt une propriété structurelle stable : tout PDF valide commence par la signature `%PDF` — un test qui reste robuste dans le temps sans être trivial.

## Pour aller plus loin (hors scope de ce projet)

Aucune gestion de mise en page avancée (pagination multi-pages avec en-têtes répétés, graphiques) n'est implémentée — Dompdf le permettrait via du CSS plus riche, laissé en exploration libre.
