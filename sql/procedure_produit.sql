DROP PROCEDURE IF EXISTS ajouter_produit;
DROP FUNCTION IF EXISTS modifier_produit;
DROP FUNCTION IF EXISTS supprimer_produit;

delimiter |

CREATE PROCEDURE ajouter_produit(IN p_prix INTEGER, IN p_nom VARCHAR(50), IN p_description TEXT)
BEGIN
    INSERT INTO
        produits
            (prix,
            nom,
            description)
    VALUES
        (p_prix,
        p_nom,
        p_description);
END|

CREATE FUNCTION modifier_produit(p_produit_id INTEGER, p_prix INTEGER, p_nom VARCHAR(50), p_description TEXT) RETURNS BOOLEAN
BEGIN
    DECLARE retour BOOLEAN;
    
    IF verifier_produit(p_produit_id) THEN
        UPDATE
            produit
        SET
            prix = p_prix,
            nom = p_nom,
            description = p_description
        WHERE
            id = p_produit_id;
        
        SET retour = TRUE;
    ELSE
        SET retour = FALSE;
    END IF;
    
    RETURN retour;
END|

CREATE FUNCTION supprimer_produit(p_produit_id INTEGER) RETURNS BOOLEAN
BEGIN
    DECLARE retour BOOLEAN;
    
    IF verifier_produit(p_produit_id) THEN
        DELETE FROM
            produit
        WHERE
            id = p_produit_id;
        
        SET retour = TRUE;
    ELSE
        SET retour = FALSE;
    END IF;
    
    RETURN retour;
END|

delimiter ;
