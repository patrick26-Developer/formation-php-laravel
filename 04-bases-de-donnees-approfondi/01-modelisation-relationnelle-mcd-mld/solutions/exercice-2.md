# Solution — Exercice 2

- **Auteur → Livre : 1-N**. Un auteur peut avoir écrit plusieurs livres (en supposant un seul auteur principal par livre), mais chaque livre a un seul auteur principal.

- **Livre ↔ Membre (via Emprunt) : N-N**. Un livre peut être emprunté par plusieurs membres différents au fil du temps (à des moments différents), et un membre peut emprunter plusieurs livres. C'est pourquoi une entité intermédiaire `Emprunt` est nécessaire — elle porte en plus ses propres attributs (dates), ce qu'une simple table pivot ne pourrait pas faire aussi naturellement.

- **Membre → CarteBibliotheque : 1-1**. Chaque membre a exactement une carte, et chaque carte appartient à un seul membre.
