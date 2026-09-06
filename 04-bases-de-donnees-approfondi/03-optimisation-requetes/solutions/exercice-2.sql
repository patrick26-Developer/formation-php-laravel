-- Original : UPPER(email) empêche l'utilisation de l'index sur "email"
-- SELECT * FROM utilisateurs WHERE UPPER(email) = 'ALICE@EXAMPLE.COM';

-- Corrigé : on compare directement la colonne, sans fonction autour d'elle.
-- On adapte la CASSE de la valeur recherchée plutôt que celle de la colonne
-- (les emails sont généralement stockés déjà en minuscules à l'inscription).
SELECT * FROM utilisateurs WHERE email = 'alice@example.com';

-- Si la casse des données existantes n'est pas fiable, la vraie solution est
-- de NORMALISER les données à l'écriture (toujours stocker l'email en
-- minuscules via strtolower() côté PHP avant l'INSERT), plutôt que de
-- compenser à la lecture avec une fonction qui désactive l'index.
