<?php

declare(strict_types=1);

class JournalApplication {
    private static ?JournalApplication $instance = null;
    private array $entrees = [];

    private function __construct() {
        // private constructor: impossible to do "new JournalApplication()"
        // from the outside, you must go through getInstance()
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

// Two "references" obtained separately...
$journalA = JournalApplication::getInstance();
$journalB = JournalApplication::getInstance();

$journalA->ajouterEntree("Application startup");
$journalB->ajouterEntree("User login");

// ...do point to the SAME instance: both entries show up here,
// whether we query $journalA or $journalB.
print_r($journalA->getEntrees());
var_dump($journalA === $journalB); // true: it's literally the same object
