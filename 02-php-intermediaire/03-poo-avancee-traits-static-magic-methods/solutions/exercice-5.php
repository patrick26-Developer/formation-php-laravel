<?php

declare(strict_types=1);

class JournalApplication {
    private static ?JournalApplication $instance = null;
    private array $entrees = [];

    private function __construct() {
        // constructeur privé : impossible de faire "new JournalApplication()"
        // depuis l'extérieur, on doit obligatoirement passer par getInstance()
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function ajouterEntree(string $message): void {
        $this->entrees[] = $message;
    }

    public function getEntrees(): array {
        return $this->entrees;
    }
}

// Deux "références" obtenues séparément...
$journalA = JournalApplication::getInstance();
$journalB = JournalApplication::getInstance();

$journalA->ajouterEntree("Démarrage de l'application");
$journalB->ajouterEntree("Connexion utilisateur");

// ...pointent bien vers la MÊME instance : les deux entrées apparaissent ici,
// que l'on interroge $journalA ou $journalB.
print_r($journalA->getEntrees());
var_dump($journalA === $journalB); // true : c'est littéralement le même objet
