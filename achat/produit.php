<?php

include_once("lib.php");
include_once("../accueil/init.php");

$idCategorie = null;

if( isConnected() ) {
    $utilisateur = getUtilisateurConnecte();
    $idCategorie = $utilisateur['categorie_id'];
}

$archives = getArchives( $idCategorie );

$produits = Produit::recupererTous();

?>

<div class="main">

    <?php
        if(count($produits) == 0) { ?>
        
        <div class="item">
            <div class="date">
            </div>
            <div class="content">
                <h1></h1>
                <div class="body">
                    <p>
                        <strong>Il n'y a aucun produit disponible.</strong>
                    </p>
                </div>
            </div>
        </div>
        <?php 
        }
        else{
        ?>
        <?php 
            foreach( $produits as $produit ) { ?>

        <div class="item">
            <div class="date">
                <div><a href="ajouter.php?id=<?php echo $produit->getId() ?>"><img src="panier.png" /></a></div>
            </div>
            <div class="content">
                <h1>
                    <?php echo htmlspecialchars($produit->getNom()) ?>
                </h1>
                <div class="body">
                    <p>
                        <?php echo $produit->getDescription() ?>
                        <hr/>
                        <p><strong>Prix: </strong> <?php echo htmlspecialchars($produit->getPrix()) ?>$</p>
                    </p>
                </div>
            </div>
        </div>

        <?php } #endfor ?>
    <?php } #endif ?>
</div>

    <?php include_once( ROOT . "common/menu.php") ?>

</div>

<?php include_once("../accueil/end.php") ?>

