<?php

/*
 * Debugging approach:
 * 1. We run the original code: "Division by zero" error on the "return" line.
 * 2. We add var_dump($notes) and var_dump(count($notes)) right before the
 *    return to confirm the hypothesis: $notesClasse is an EMPTY array,
 *    so count($notes) is 0, and $total / 0 causes the error.
 * 3. Root cause: the function doesn't handle the empty-array case.
 */

function calculerMoyenne(array $notes): float {
    // Fix: explicitly handle the case where there are no grades, rather
    // than letting a division by zero happen.
    if (count($notes) === 0) {
        throw new Exception("Cannot calculate an average with no grades.");
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
    echo "Error: " . $e->getMessage();
}
