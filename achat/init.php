<?php

include_once("../conf/init.php");

include_once( ROOT . "lib/transaction.php" );
include_once( ROOT . "lib/urls.php" );
include_once( ROOT . "lib/isConnected.php");
include_once( ROOT . "lib/accueil.php" );
include_once( ROOT . "lib/theme.php" );

if( !isConnected() ) {
    header( "Location: " . URL_ROOT );
}

?>
