<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../src/Auth.php';

Auth::deconnecter();

header('Location: connexion.php');
exit;
