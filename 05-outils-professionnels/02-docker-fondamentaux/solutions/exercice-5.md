# Solution — Exercice 5

```bash
docker build -t app-debian -f Dockerfile.debian .      # basé sur php:8.3-apache
docker build -t app-alpine -f Dockerfile.alpine .      # basé sur php:8.3-apache-alpine

docker images
# REPOSITORY    TAG       SIZE
# app-debian    latest    ~450-500 MB
# app-alpine    latest    ~90-120 MB
```

(Les tailles exactes varient selon les versions, mais l'écart de plusieurs
centaines de Mo est systématique.)

## Compromis Alpine vs Debian/Ubuntu

**Alpine** (basé sur `musl libc` plutôt que `glibc`, et `busybox`) :
- ✅ Images beaucoup plus légères → téléchargement et déploiement plus rapides, moins d'espace disque.
- ✅ Surface d'attaque réduite (moins de paquets installés = moins de failles potentielles).
- ⚠️ Certaines extensions PHP ou paquets système compilés attendent `glibc` et peuvent nécessiter des étapes d'installation différentes, voire ne pas être disponibles du tout.
- ⚠️ Débogage parfois plus difficile : moins d'outils standards préinstallés (`bash` complet, utilitaires GNU...).

**Debian/Ubuntu** :
- ✅ Compatibilité maximale avec l'écosystème PHP et ses extensions (`apt-get install` couvre presque tout).
- ✅ Outils de débogage familiers déjà présents.
- ⚠️ Images nettement plus lourdes, télécharger/redéployer prend plus de temps.

**Règle pratique** : commencer avec Alpine par défaut pour sa légèreté ; basculer sur une image Debian/Ubuntu uniquement si une dépendance spécifique du projet l'exige (rencontré parfois avec des extensions PHP peu courantes ou des outils PDF/image).
