<?php

include_once "lib.php";

$tags = "<strong><em><span><ul><ol><li><br>";

if(isset($_POST['titre']) && isset($_POST['texte']) && isset($_POST['categorie'])) {
    if(!empty($_POST['titre']) && !empty($_POST['texte']) && !empty($_POST['categorie'])) {

        $tags = "<strong><em><span><ul><ol><li><br>";
        $texte = strip_tags( stripslashes( $_POST['texte'] ), $tags );

		ajouterNews($_POST['titre'], $texte, $_POST['categorie']);
	}
	else {
		echo 'Vous devez remplir tous les champs pour ajouter une nouvelle. <a href="ajouter.php">Retourner au formulaire</a>.';
	}
}
else {
	include '../../common/header.php';
	include 'formulaire_ajouter.php';
	include "../../common/footer.php";
}

include "../../conf/end.php";

?>
