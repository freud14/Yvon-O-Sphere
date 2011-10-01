DROP FUNCTION IF EXISTS creer_transaction;
DROP FUNCTION IF EXISTS payer_transaction;
DROP FUNCTION IF EXISTS derniere_transaction;
DROP FUNCTION IF EXISTS vider_transaction;

delimiter |

CREATE FUNCTION creer_transaction(p_utilisateur_id INTEGER) RETURNS INTEGER
BEGIN
    DECLARE id INTEGER;
    
    IF verifier_utilisateur(p_utilisateur_id) THEN
        INSERT INTO
            transactions
                (utilisateur_id)
        VALUES
            (p_utilisateur_id);
        
        SET id = LAST_INSERT_ID();
    ELSE
        SET id = -1;
    END IF;
    
    RETURN id;
END|

CREATE FUNCTION payer_transaction(p_transaction_id INTEGER, p_montant INTEGER, p_type_paiement VARCHAR(20)) RETURNS BOOLEAN
BEGIN
    DECLARE retour BOOLEAN;
    DECLARE count_facture INTEGER;
    
    IF verifier_transaction(p_transaction_id) THEN  
        SELECT
            COUNT(*)
        INTO
            count_facture
        FROM
            factures
        WHERE
            transaction_id = p_transaction_id;
        
        IF count_facture = 0 THEN
            INSERT INTO
                factures
                    (montant,
                    type_paiement,
                    transaction_id)
            VALUES
                (p_montant,
                p_type_paiement,
                p_transaction_id);
                
            SET retour = TRUE;
        ELSE
            SET retour = FALSE;
        END IF;
        
    ELSE
        SET retour = FALSE;
    END IF;
    
    RETURN retour;
END|

CREATE FUNCTION derniere_transaction(p_utilisateur_id INTEGER) RETURNS INTEGER
BEGIN
    DECLARE retour INTEGER;
    DECLARE count_transaction INTEGER;
    
    IF verifier_utilisateur(p_utilisateur_id) THEN  
        SELECT
            COUNT(*)
        INTO
            count_transaction
        FROM
            transactions
                LEFT JOIN
                    factures
                        ON  transactions.id = factures.transaction_id
        WHERE
            factures.id IS NULL AND
            transactions.utilisateur_id = p_utilisateur_id;
        
        IF count_transaction = 0 THEN
            SET retour = creer_transaction(p_utilisateur_id);
        ELSEIF count_transaction = 1 THEN
            SELECT
                transactions.id
            INTO
                retour
            FROM
                transactions
                    LEFT JOIN
                        factures
                            ON  transactions.id = factures.transaction_id
            WHERE
                factures.id IS NULL AND
                transactions.utilisateur_id = p_utilisateur_id;
        ELSE
            SET retour = -1;
        END IF;
    ELSE
        SET retour = -1;
    END IF;
    
    RETURN retour;
END|

CREATE FUNCTION vider_transaction(p_transaction_id INTEGER) RETURNS BOOLEAN
BEGIN
    DECLARE retour BOOLEAN;
    DECLARE count_facture INTEGER;
    
    IF verifier_transaction(p_transaction_id) THEN  
        SELECT
            COUNT(*)
        INTO
            count_facture
        FROM
            transactions
                LEFT JOIN
                    factures
                        ON  transactions.id = factures.transaction_id
        WHERE
            factures.id IS NULL AND
            transactions.id = p_transaction_id;
            
            
        IF count_facture = 0 THEN
            DELETE FROM
                produits_transactions
            WHERE
                transaction_id = p_transaction_id;
            
            SET retour = TRUE;
        ELSE
            SET retour = FALSE;
        END IF;
    ELSE
        SET retour = FALSE;
    END IF;
    
    RETURN retour;
END|

DELIMITER ;

