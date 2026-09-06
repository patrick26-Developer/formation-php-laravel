-- Tentative de suppression d'un client ayant des commandes existantes,
-- sans ON DELETE CASCADE défini sur la contrainte :
DELETE FROM clients WHERE id = 1;

-- Erreur obtenue (message exact selon la version de MySQL) :
-- ERROR 1451 (23000): Cannot delete or update a parent row: a foreign key
-- constraint fails (`exercices_sql_04`.`commandes`, CONSTRAINT `commandes_ibfk_1`
-- FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`))

/*
 * Ce comportement RESTRICT (le défaut) est une PROTECTION, pas une gêne :
 * sans lui, supprimer ce client laisserait des commandes en base pointant
 * vers un client_id qui n'existe plus (des "orphelines"), ce qui casserait
 * silencieusement toute requête ou jointure future sur ces commandes
 * (impossible d'afficher le nom du client d'une commande orpheline, par
 * exemple). MySQL préfère refuser l'opération et forcer le développeur à
 * décider explicitement quoi faire des commandes liées : les supprimer
 * d'abord, les réattribuer à un autre client, ou anonymiser le client
 * (RGPD) sans supprimer son historique de commandes.
 */
