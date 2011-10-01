<?php

include_once("../../conf/init.php");

include_once( ROOT . "lib/isConnected.php" );
include_once( ROOT . "lib/utilisateur.php" );
include_once( ROOT . "lib/urls.php" );
include_once( ROOT . "lib/categorie.php" );

if( !isConnectedAsAdmin() ) {
    header("Location: ". url("admin/connexion.php"));
}

include_once( ROOT . "common/header.php" );

?>
