-- Attempting to delete a client who has existing orders,
-- with no ON DELETE CASCADE defined on the constraint:
DELETE FROM clients WHERE id = 1;

-- Error obtained (exact message depends on the MySQL version):
-- ERROR 1451 (23000): Cannot delete or update a parent row: a foreign key
-- constraint fails (`exercices_sql_04`.`commandes`, CONSTRAINT `commandes_ibfk_1`
-- FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`))

/*
 * This RESTRICT behavior (the default) is a PROTECTION, not an annoyance:
 * without it, deleting this client would leave orders in the database
 * pointing to a client_id that no longer exists (an "orphan" row),
 * which would silently break any future query or join on those orders
 * (impossible to show the client's name for an orphaned order, for
 * example). MySQL prefers to refuse the operation and force the
 * developer to explicitly decide what to do with the related orders:
 * delete them first, reassign them to another client, or anonymize the
 * client (GDPR) without deleting their order history.
 */
