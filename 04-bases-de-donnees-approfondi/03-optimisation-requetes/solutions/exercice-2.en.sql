-- Original: UPPER(email) prevents the index on "email" from being used
-- SELECT * FROM utilisateurs WHERE UPPER(email) = 'ALICE@EXAMPLE.COM';

-- Fixed: we compare the column directly, without wrapping it in a function.
-- We adapt the CASE of the searched value instead of the column's
-- (emails are usually already stored lowercase at sign-up).
SELECT * FROM utilisateurs WHERE email = 'alice@example.com';

-- If the case of the existing data can't be trusted, the real fix is to
-- NORMALIZE the data on write (always store the email lowercase via
-- strtolower() on the PHP side before the INSERT), rather than
-- compensating on read with a function that disables the index.
