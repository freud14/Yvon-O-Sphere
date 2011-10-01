DROP FUNCTION IF EXISTS ajouter_produit_transaction;
DROP FUNCTION IF EXISTS retirer_produit_transaction;
DROP FUNCTION IF EXISTS maj_produit_transaction;
DROP FUNCTION IF EXISTS ajout_quantite_produit_transaction;

delimiter |

CREATE FUNCTION ajouter_produit_transaction(p_produit_id INTEGER, p_transaction_id INTEGER, p_quantite INTEGER) RETURNS BOOLEAN
BEGIN
    DECLARE retour BOOLEAN;

    IF verifier_produit(p_produit_id) AND verifier_transaction(p_transaction_id) AND NOT verifier_produit_transaction(p_produit_id, p_transaction_id) THEN
        INSERT INTO
            produits_transactions
                (transaction_id,
                produit_id,
                quantite)
        VALUES
            (p_transaction_id,
            p_produit_id,
            p_quantite);
        SET retour = TRUE;
    ELSE
        SET retour = FALSE;
    END IF;
    
    RETURN retour;
END|


CREATE FUNCTION retirer_produit_transaction(p_produit_id INTEGER, p_transaction_id INTEGER) RETURNS BOOLEAN
BEGIN
    DECLARE retour BOOLEAN;
    
    IF verifier_produit_transaction(p_produit_id, p_transaction_id) THEN
        DELETE FROM
            produits_transactions
        WHERE 
            produit_id = p_produit_id AND 
            transaction_id = p_transaction_id;
            
        SET retour = TRUE;
    ELSE
        SET retour = FALSE;
    END IF;
    
    RETURN retour;
END|

CREATE FUNCTION maj_produit_transaction(p_produit_id INTEGER, p_transaction_id INTEGER, p_quantite INTEGER) RETURNS BOOLEAN
BEGIN
    DECLARE retour BOOLEAN;
    
    IF p_quantite = 0 THEN
        SELECT retirer_produit_transaction(p_produit_id, p_transaction_id) INTO retour;
    ELSE  
        IF verifier_produit(p_produit_id) AND verifier_transaction(p_transaction_id) AND verifier_produit_transaction(p_produit_id, p_transaction_id) THEN
            UPDATE
                produits_transactions
            SET
                quantite = p_quantite
            WHERE
                produit_id = p_produit_id AND 
                transaction_id = p_transaction_id;
                
            SET retour = TRUE;
        ELSE
            SET retour = ajouter_produit_transaction(p_produit_id, p_transaction_id, p_quantite);
        END IF;
    END IF;
    
    RETURN retour;
END|

CREATE FUNCTION ajout_quantite_produit_transaction(p_produit_id INTEGER, p_transaction_id INTEGER, p_quantite INTEGER) RETURNS BOOLEAN
BEGIN
    DECLARE retour BOOLEAN;
    
    IF verifier_produit(p_produit_id) AND verifier_transaction(p_transaction_id) AND verifier_produit_transaction(p_produit_id, p_transaction_id) THEN
        UPDATE
            produits_transactions
        SET
            quantite = quantite + p_quantite
        WHERE
            produit_id = p_produit_id AND 
            transaction_id = p_transaction_id;
            
        SET retour = TRUE;
    ELSE
        SET retour = ajouter_produit_transaction(p_produit_id, p_transaction_id, p_quantite);
    END IF;
    
    RETURN retour;
END|

delimiter ;
