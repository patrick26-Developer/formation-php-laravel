<?php

declare(strict_types=1);

/**
 * Authentification "maison" (module 02.5) : inscription non incluse
 * volontairement (voir seed.php pour créer un utilisateur de démonstration)
 * afin de garder ce mini-projet centré sur le CRUD des tâches.
 */
class Auth {
    public function __construct(private PDO $pdo) {}

    public function connecter(string $email, string $motDePasse): bool {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $utilisateur = $stmt->fetch();

        if ($utilisateur === false || !password_verify($motDePasse, $utilisateur['mot_de_passe'])) {
            return false;
        }

        session_regenerate_id(true); // évite la fixation de session après connexion
        $_SESSION['utilisateur_id'] = $utilisateur['id'];
        $_SESSION['utilisateur_email'] = $utilisateur['email'];

        return true;
    }

    public static function deconnecter(): void {
        $_SESSION = [];
        session_destroy();
    }

    public static function estConnecte(): bool {
        return isset($_SESSION['utilisateur_id']);
    }

    public static function exigerConnexion(): void {
        if (!self::estConnecte()) {
            header('Location: connexion.php');
            exit;
        }
    }

    public static function idUtilisateurConnecte(): int {
        return (int) $_SESSION['utilisateur_id'];
    }
}
