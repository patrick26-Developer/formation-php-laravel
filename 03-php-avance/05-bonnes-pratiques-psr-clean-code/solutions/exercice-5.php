<?php

declare(strict_types=1);

/*
 * Découpage en 4 responsabilités distinctes, chacune avec une seule
 * raison de changer :
 * - ValidateurEmail : change si les règles de validation d'email changent
 * - ServiceEmail : change si le fournisseur/mécanisme d'envoi d'email change
 * - JournalActivite : change si la façon de journaliser change (fichier -> base -> service externe)
 * - InscriptionUtilisateur : orchestre les autres, change si le PROCESSUS d'inscription change
 */

class ValidateurEmail
{
    public function valider(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email invalide : $email");
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
        // ... requête SQL d'insertion, utilisant $hash ...

        $this->serviceEmail->envoyer($email, "Bienvenue", "Merci de votre inscription");
        $this->journal->enregistrer("Nouveau compte : $email");
    }
}

// Chaque classe est maintenant testable indépendamment (avec des mocks pour
// ServiceEmail et JournalActivite, comme au module 03.3), et modifiable
// sans risquer d'impacter les autres responsabilités.
