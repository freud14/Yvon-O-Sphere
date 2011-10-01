DROP FUNCTION IF EXISTS verifier_utilisateur;
DROP FUNCTION IF EXISTS verifier_produit;
DROP FUNCTION IF EXISTS verifier_transaction;
DROP FUNCTION IF EXISTS verifier_produit_transaction;

delimiter |

CREATE FUNCTION verifier_utilisateur(p_utilisateur_id INTEGER) RETURNS BOOLEAN
BEGIN
    DECLARE retour BOOLEAN;
    DECLARE count_utilisateur INTEGER;
    
    SELECT
        COUNT(*)
    INTO
        count_utilisateur
    FROM
        utilisateurs
    WHERE
        id = p_utilisateur_id;
    
    IF count_utilisateur = 1 THEN
        SET retour = TRUE;
    ELSE
        SET retour = FALSE;
    END IF;
    
    RETURN retour;
END|

CREATE FUNCTION verifier_produit(p_produit_id INTEGER) RETURNS BOOLEAN
BEGIN
    DECLARE retour BOOLEAN;
    DECLARE count_produit INTEGER;
    
    SELECT
        COUNT(*)
    INTO
        count_produit
    FROM
        produits
    WHERE
        id = p_produit_id;
    
    IF count_produit = 1 THEN
        SET retour = TRUE;
    ELSE
        SET retour = FALSE;
    END IF;
    
    RETURN retour;
END|

CREATE FUNCTION verifier_transaction(p_transaction_id INTEGER) RETURNS BOOLEAN
BEGIN
    DECLARE retour BOOLEAN;
    DECLARE count_transaction INTEGER;
    
    SELECT
        COUNT(*)
    INTO
        count_transaction
    FROM
        transactions
    WHERE
        id = p_transaction_id;
    
    IF count_transaction = 1 THEN
        SET retour = TRUE;
    ELSE
        SET retour = FALSE;
    END IF;
    
    RETURN retour;
END|

CREATE FUNCTION verifier_produit_transaction(p_produit_id INTEGER, p_transaction_id INTEGER) RETURNS BOOLEAN
BEGIN
    DECLARE count_produit_transaction INTEGER;
    DECLARE retour BOOLEAN;

    SELECT 
        COUNT(*) 
    INTO 
        count_produit_transaction 
    FROM 
        produits_transactions 
    WHERE 
        produit_id = p_produit_id AND 
        transaction_id = p_transaction_id;
    
    IF count_produit_transaction = 1 THEN
        SET retour = TRUE;
    ELSE
        SET retour = FALSE;
    END IF;
    
    RETURN retour;
END|

delimiter ;

