<?php

declare(strict_types=1);

interface CritereTri {
    public function versSql(): string;
}

class TriParAnnee implements CritereTri {
    public function __construct(private string $ordre = 'DESC') {}

    public function versSql(): string {
        $ordre = strtoupper($this->ordre) === 'ASC' ? 'ASC' : 'DESC';
        return "annee $ordre";
    }
}

class TriParTitre implements CritereTri {
    public function __construct(private string $ordre = 'ASC') {}

    public function versSql(): string {
        $ordre = strtoupper($this->ordre) === 'ASC' ? 'ASC' : 'DESC';
        return "titre $ordre";
    }
}

class LivreRepository {
    public function __construct(private PDO $pdo) {}

    public function lister(CritereTri $tri): array {
        // The column name NEVER comes directly from the user here:
        // it comes from a PHP class we wrote and validated ourselves.
        // It's the ONLY type allowed to produce this part of the SQL.
        $sql = "SELECT * FROM livres ORDER BY " . $tri->versSql();
        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll();
    }
}

/*
 * Comparison with the whitelist approach from module 02.9:
 *
 * ADVANTAGE of this Strategy-based approach:
 * - Impossible to get it wrong: you CANNOT pass an arbitrary string,
 *   only an instance of an existing PHP class that implements
 *   CritereTri. The language's typing prevents the mistake at
 *   compile/static-analysis time, not just at runtime.
 * - Each sort criterion can have its own logic (order validation,
 *   default value...) cleanly encapsulated.
 *
 * DRAWBACK:
 * - More verbose for a simple need: you need one class per sort
 *   criterion, whereas a whitelist (a plain array of allowed strings)
 *   is more than enough for a basic case like module 02.9's.
 *
 * Rule of thumb: a whitelist works great for a small number of
 * sortable columns. Strategy becomes worthwhile once the sorting logic
 * gets more complex (combined sort on several columns, computed sort...).
 */
