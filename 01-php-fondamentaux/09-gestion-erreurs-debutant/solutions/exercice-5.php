<?php

/*
 * Démarche de débogage :
 * 1. On exécute le code original : erreur "Division by zero" ligne du "return".
 * 2. On ajoute var_dump($notes) et var_dump(count($notes)) juste avant le
 *    return pour confirmer l'hypothèse : $notesClasse est un tableau VIDE,
 *    donc count($notes) vaut 0, et $total / 0 provoque l'erreur.
 * 3. La cause racine : la fonction ne gère pas le cas d'un tableau vide.
 */

function calculerMoyenne(array $notes): float {
    // Correction : on gère explicitement le cas où il n'y a pas de notes,
    // plutôt que de laisser une division par zéro se produire.
    if (count($notes) === 0) {
        throw new Exception("Impossible de calculer une moyenne sans notes.");
    }

    $total = 0;
    foreach ($notes as $note) {
        $total += $note;
    }

    return $total / count($notes);
}

$notesClasse = [];

try {
    echo calculerMoyenne($notesClasse);
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
