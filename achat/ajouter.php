<?php

include_once "lib.php";

try {
    $panier_actuel = Transaction::derniere($_SESSION['id_utilisateur']);
}
catch(Exception $e) {
    die("Impossible d'initialiser le panier d'achat.");
}

try {
    $panier_actuel->ajouterProduit(intval($_GET['id']));
}
catch(Exception $e) {
    die("Impossible d'ajouter le produit.");
}

header("Location: ".url("achat/panier.php"));
?>
