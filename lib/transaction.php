<?php

include_once( "database.php" );
include_once( ROOT . "lib/produit.php" );

class Transaction
{
    private $id;
    private $utilisateur_id;

    function __construct( $id, $utilisateur_id ) 
    {
        $this->id = $id;
        $this->utilisateur_id = $utilisateur_id;
    }

    public static function derniere( $utilisateur_id )
    {
        $sql = "SELECT derniere_transaction( "
            . mysql_escape_string( $utilisateur_id )
            . " )";

        $resultat = requete_un_resultat( $sql );

        if( $resultat[0] < 0 ) {
            throw new Exception( "Aucune transaction pour l'utilisateur", -1 );
        }

        return new self( $resultat[0], $utilisateur_id );

    }

    public function produits()
    {

        $produits = array();

        $sql = "SELECT produit_id, quantite FROM produits_transactions WHERE transaction_id = "
            . mysql_escape_string( $this->id );

        $resultats = requete_resultats( $sql );

        foreach( $resultats as $resultat ) {
            $produit = Produit::recuperer( $resultat['produit_id'] );
            $produit->setQuantite( $resultat['quantite'] );
            $produits[] = $produit;
        }

        return $produits;

    }
    
    public function ajouterProduit($id_produit)
    {
        $sql = "SELECT ajout_quantite_produit_transaction(".intval( $id_produit ).", ". intval($this->id) . ", 1)";

        $resultat = requete_un_resultat( $sql );

        if( $resultat[0] < 0 ) {
            throw new Exception( "Impossible d'ajouter le produit.", -1 );
        }
    }

    public function retirerProduit( $id_produit )
    {
        $sql = "SELECT maj_produit_transaction( "
            . mysql_escape_string( $id_produit )
            . ", " . mysql_escape_string( $this->id )
            . ", 0 ) ";

        $resultat = requete_un_resultat( $sql );

        if( $resultat[0] < 0 ) {
            throw new Exception( "Impossible de retirer le produit.", -1 );
        }

    }

    public function prixTotal()
    {
        $total = 0;
        foreach( $this->produits() as $produit ) {
            $total += $produit->getPrix() * $produit->getQuantite();
        }

        return $total;

    }

}
?>
