<?php

/*
 * A : FAILLE XSS.
 * $_GET['nom'] est réaffiché directement en HTML sans htmlspecialchars().
 * Un attaquant peut passer ?nom=<script>...</script> pour exécuter du JS.
 *
 * B : AUCUNE FAILLE.
 * Requête préparée : $_GET['id'] est passé séparément via execute(),
 * jamais concaténé dans le texte SQL. C'est le pattern à toujours suivre.
 *
 * C : FAILLE D'INJECTION SQL.
 * $_GET['nom'] est concaténé directement dans le texte de la requête.
 * Un attaquant peut passer ?nom=' OR '1'='1 pour manipuler la requête.
 *
 * D : AUCUNE FAILLE (pour l'affichage).
 * htmlspecialchars() échappe correctement la donnée avant affichage HTML.
 */
