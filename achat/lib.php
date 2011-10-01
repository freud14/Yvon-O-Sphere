<?php

include_once "../conf/init.php";
include_once "../lib/isConnected.php";
include_once "../lib/urls.php";
include_once "../lib/produit.php";
include_once "../lib/transaction.php";

if(!isConnected()) {
	header("Location: ".url("accueil/connexion.php"));
}

?>
