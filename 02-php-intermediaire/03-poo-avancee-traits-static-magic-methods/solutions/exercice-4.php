<?php

declare(strict_types=1);

enum Role {
    case Admin;
    case Editeur;
    case Lecteur;

    public function peutModifier(): bool {
        return match ($this) {
            self::Admin, self::Editeur => true,
            self::Lecteur => false,
        };
    }

    public function libelle(): string {
        return match ($this) {
            self::Admin => "Administrateur",
            self::Editeur => "Éditeur",
            self::Lecteur => "Lecteur",
        };
    }
}

foreach (Role::cases() as $role) {
    $permission = $role->peutModifier() ? "peut modifier" : "lecture seule";
    echo $role->libelle() . " : $permission\n";
}
