<?php

declare(strict_types=1);

class ConnexionBaseDeDonnees {
    private static ?PDO $instance = null;

    private function __construct() {
        // constructeur privé : on force l'accès via obtenir()
    }

    public static function obtenir(): PDO {
        if (self::$instance === null) {
            self::$instance = new PDO(
                "mysql:host=127.0.0.1;dbname=formation_php_exercices;charset=utf8mb4",
                "root",
                "",
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        }

        return self::$instance;
    }
}

// Réécriture de l'exercice 2 avec le Singleton
$pdo = ConnexionBaseDeDonnees::obtenir();

$stmt = $pdo->prepare("INSERT INTO livres (titre, auteur, annee) VALUES (:titre, :auteur, :annee)");
$stmt->execute(['titre' => 'Brave New World', 'auteur' => 'Aldous Huxley', 'annee' => 1932]);
echo "Livre créé avec l'ID " . $pdo->lastInsertId() . "\n";

// Réécriture de l'exercice 3 : ConnexionBaseDeDonnees::obtenir() retourne
// TOUJOURS la même instance PDO, pas besoin de reconnecter.
$pdoReutilise = ConnexionBaseDeDonnees::obtenir();
$stmt = $pdoReutilise->query("SELECT * FROM livres ORDER BY annee DESC");
foreach ($stmt->fetchAll() as $livre) {
    echo "{$livre['titre']} ({$livre['annee']})\n";
}

var_dump($pdo === $pdoReutilise); // true : la même connexion est réutilisée partout
