
/*

To create database:

CREATE DATABASE blogue CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
GRANT ALL PRIVILEGES ON blogue.* TO 'blogue'@'localhost' IDENTIFIED BY '1234';

*/

CREATE TABLE IF NOT EXISTS categories (
    id      INTEGER         NOT NULL                AUTO_INCREMENT,
    nom     VARCHAR(40)     NOT NULL,
    /* contraintes */
    PRIMARY KEY ( id )
);

CREATE TABLE IF NOT EXISTS nouvelles (
    id              INTEGER         NOT NULL        AUTO_INCREMENT,
    nom             VARCHAR(80)     NOT NULL,
    contenu         TEXT            NOT NULL,
    date_parution   TIMESTAMP       NOT NULL        DEFAULT CURRENT_TIMESTAMP,

    /* cles etrangeres */
    categorie_id    INTEGER         NOT NULL,
    /* contraintes */
    PRIMARY KEY (id),
    CONSTRAINT nv_categorie_id FOREIGN KEY ( categorie_id ) REFERENCES categories ( id )
);

CREATE TABLE IF NOT EXISTS utilisateurs (
    id              INTEGER         NOT NULL        AUTO_INCREMENT,
    username        VARCHAR(40)     NOT NULL,
    password        VARCHAR(32)     NOT NULL,
    nom             VARCHAR(80)     NOT NULL,
    prenom          VARCHAR(80)     NOT NULL,
    admin           BOOLEAN         NOT NULL        DEFAULT FALSE,
    theme           VARCHAR(40)     NOT NULL        DEFAULT 'vert',
    /* cles etrangeres */
    categorie_id    INTEGER         NOT NULL,
    session_id      VARCHAR(32)     NULL,
    /* contraintes */
    PRIMARY KEY ( id ),
    CONSTRAINT ut_categorie_id
    FOREIGN KEY ( categorie_id )
    REFERENCES categories ( id )

);


/**
    Tables pour la gestion des produits.
*/

DROP TABLE IF EXISTS produits_transactions;
DROP TABLE IF EXISTS produits;
DROP TABLE IF EXISTS factures;
DROP TABLE IF EXISTS transactions;

CREATE TABLE IF NOT EXISTS transactions (
    id              INTEGER         NOT NULL        AUTO_INCREMENT,
    /* cles etrangeres */
    utilisateur_id  INTEGER         NOT NULL,
    /* contraintes */
    PRIMARY KEY ( id ),
    CONSTRAINT ut_transaction_id
        FOREIGN KEY ( utilisateur_id )
        REFERENCES utilisateurs ( id )
        
);


CREATE TABLE IF NOT EXISTS factures (
    id              INTEGER         NOT NULL        AUTO_INCREMENT,
    montant         INTEGER         NOT NULL,
    type_paiement   VARCHAR(20)     NOT NULL,
    date_paiement   TIMESTAMP       NOT NULL        DEFAULT CURRENT_TIMESTAMP,
    /* cles etrangeres */
    transaction_id  INTEGER         NOT NULL,
    /* contraintes */
    PRIMARY KEY ( id ),
    CONSTRAINT transaction_facture_id
        FOREIGN KEY ( transaction_id )
        REFERENCES transactions ( id )
        
);


CREATE TABLE IF NOT EXISTS produits (
    id              INTEGER         NOT NULL        AUTO_INCREMENT,
    prix            INTEGER         NOT NULL,
    nom             VARCHAR(50)     NOT NULL,
    description     TEXT            NOT NULL,
    /* contraintes */
    PRIMARY KEY ( id )
    
);


CREATE TABLE IF NOT EXISTS produits_transactions (
    /* cles etrangeres et cles primaires */
    transaction_id  INTEGER         NOT NULL,
    produit_id      INTEGER         NOT NULL,
    quantite        INTEGER         NOT NULL,
    /* contraintes */
    PRIMARY KEY ( transaction_id,  produit_id ),
    CONSTRAINT pt_transaction_id
        FOREIGN KEY ( transaction_id )
        REFERENCES transactions ( id ),
    CONSTRAINT pt_produit_id
        FOREIGN KEY ( produit_id )
        REFERENCES produits ( id )

);

