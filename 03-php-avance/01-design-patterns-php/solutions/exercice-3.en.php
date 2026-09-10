<?php

declare(strict_types=1);

interface ObservateurAvis {
    public function notifier(int $note): void;
}

class CalculMoyenneObservateur implements ObservateurAvis {
    private int $total = 0;
    private int $nombreAvis = 0;

    public function notifier(int $note): void {
        $this->total += $note;
        $this->nombreAvis++;
        echo "Current average: " . round($this->total / $this->nombreAvis, 2) . "\n";
    }
}

class AlerteAvisNegatifObservateur implements ObservateurAvis {
    public function notifier(int $note): void {
        if ($note < 2) {
            echo "⚠️ ALERT: negative review received (rating: $note/5)\n";
        }
    }
}

class GestionnaireAvis {
    /** @var ObservateurAvis[] */
    private array $observateurs = [];

    public function ajouterObservateur(ObservateurAvis $observateur): void {
        $this->observateurs[] = $observateur;
    }

    public function ajouterAvis(int $note): void {
        foreach ($this->observateurs as $observateur) {
            $observateur->notifier($note);
        }
    }
}

$gestionnaire = new GestionnaireAvis();
$gestionnaire->ajouterObservateur(new CalculMoyenneObservateur());
$gestionnaire->ajouterObservateur(new AlerteAvisNegatifObservateur());

$gestionnaire->ajouterAvis(5);
$gestionnaire->ajouterAvis(4);
$gestionnaire->ajouterAvis(1); // triggers the alert
