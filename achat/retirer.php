<?php

include_once( "init.php" );

if( isset( $_GET['idProduit'] ) ) {

    $utilisateur = getUtilisateurConnecte();
    $transaction = Transaction::derniere( $utilisateur['id'] );
    $transaction->retirerProduit( $_GET['idProduit'] );

}

header("Location: " . url( "achat/panier.php" ) );

?>
