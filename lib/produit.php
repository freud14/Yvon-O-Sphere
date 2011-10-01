<?php

include_once( "database.php" );

class Produit
{

    private $id;
    private $prix;
    private $nom;
    private $description;
    private $quantite;

    function __construct( $id, $prix, $nom, $description, $quantite = null )
    {

        $this->id = $id;
        $this->prix = $prix;
        $this->nom = $nom;
        $this->description = $description;
        $this->quantite = $quantite;

    }

    public function setQuantite( $quantite ) 
    {
        $this->quantite = $quantite;
    }

    static public function recuperer( $id ) 
    {

        $sql = "SELECT * FROM produits WHERE id = "
            . mysql_escape_string( $id ) ;

        $resultat = requete_un_resultat( $sql );

        return new self(
            $resultat['id'],
            $resultat['prix'],
            $resultat['nom'],
            $resultat['description']
        );

    }

    static public function recupererTous()
    {
        $sql = "SELECT id, prix, nom, description FROM produits";

        $produits = requete_resultats($sql);
        
        for($i = 0; $i < count($produits); ++$i) {
            $produits[$i] = new Produit($produits[$i]['id'], $produits[$i]['prix'], $produits[$i]['nom'], $produits[$i]['description']);
        }
        
        return $produits;
    }

    public function getId() {
        return $this->id;
    }
    
    public function getPrix() {
        return $this->prix;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getDescription() {
        return $this->description;
    }
    
    public function getQuantite() {
        return $this->quantite;
    }

}
