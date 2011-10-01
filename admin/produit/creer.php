<?php

include_once( "init.php" );

?>

<h1>Création d'un produit</h1>

<a href="<?php echourl(" admin/produit" ) ?>">Retour à la liste produits</a>

<form name="creerProduit" action="creer.php" method="post">
    <?php include_once( "formulaire.php" ) ?>
</form>

<?php include_once( "end.php" ) ?>
