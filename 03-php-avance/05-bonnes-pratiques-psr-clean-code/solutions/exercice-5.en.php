<?php

declare(strict_types=1);

/*
 * Split into 4 distinct responsibilities, each with a single
 * reason to change:
 * - ValidateurEmail: changes if email validation rules change
 * - ServiceEmail: changes if the email-sending provider/mechanism changes
 * - JournalActivite: changes if the logging method changes (file -> database -> external service)
 * - InscriptionUtilisateur: orchestrates the others, changes if the registration PROCESS changes
 */

class ValidateurEmail
{
    public function valider(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email: $email");
        }
    }
}

class ServiceEmail
{
    public function envoyer(string $destinataire, string $sujet, string $message): void
    {
        mail($destinataire, $sujet, $message);
    }
}

class JournalActivite
{
    public function __construct(private string $cheminFichier = __DIR__ . '/journal.log')
    {
    }

    public function enregistrer(string $message): void
    {
        file_put_contents($this->cheminFichier, date('Y-m-d H:i:s') . " - $message\n", FILE_APPEND);
    }
}

class InscriptionUtilisateur
{
    public function __construct(
        private ValidateurEmail $validateur,
        private ServiceEmail $serviceEmail,
        private JournalActivite $journal,
    ) {
    }

    public function creerCompte(string $email, string $motDePasse): void
    {
        $this->validateur->valider($email);

        $hash = password_hash($motDePasse, PASSWORD_DEFAULT);
        // ... SQL insert query, using $hash ...

        $this->serviceEmail->envoyer($email, "Welcome", "Thank you for signing up");
        $this->journal->enregistrer("New account: $email");
    }
}

// Each class is now independently testable (with mocks for
// ServiceEmail and JournalActivite, as in module 03.3), and modifiable
// without risking impact on the other responsibilities.
