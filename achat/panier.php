<?php

include_once( "init.php" );

$utilisateur = getUtilisateurConnecte();
$transaction = Transaction::derniere( $utilisateur['id'] );
$produits = $transaction->produits();

include_once( "header.php" );

?>

<div class='main'>

    <h1 class="title">Mon panier</h1>

    <?php if( count( $produits ) == 0 ) { ?>

        <div class="item">
            <div class="date">
            </div>
            <div class="content">
                <p>Aucun produit dans le panier</p>
            </div>
        </div>

    <?php } else { ?>

    <?php foreach( $produits as $produit ) { ?>
        <div class="item">

            <div class="date">
                <div>
                    <a href="<?php echourl( "achat/retirer.php?idProduit=" . intval( $produit->getId() ) ) ?>">
                        <img src="retirer.png" />
                    </a>
                </div>
            </div>

            <div class="content">
                <h1>
                    <?php echo $produit->getNom() ?>
                </h1>

                <div class="body">
                    <p><?php echo $produit->getDescription() ?></p>
                    <hr />
                    <p>
                        <strong>Prix : </strong><?php echo $produit->getPrix() ?> $<br />
                        <strong>Quantité : </strong><?php echo $produit->getQuantite() ?>
                    </p>
                </div>

            </div>

        </div>

    <?php } #endfor ?>

    <?php } #endif ?>

    <div class="item">
        <div class="date">
        </div>
        <div class="content">
            <h1>Total : <?php echo $transaction->prixTotal() ?> $</h1>
        </div>
    </div>

</div>

<?php include_once( ROOT . "common/menu.php" ) ?>

<?php include_once( "end.php" ) ?>
