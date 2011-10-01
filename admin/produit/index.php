<?php

include_once( "init.php" );
include_once( ROOT . "lib/produit.php" );

?>

<h1>Gestion des produits</h1>

<a href="ajouter.php">Créer un nouveau produit</a><br />
<a href="<?php echourl( "admin" ) ?>">Retour à l'administration</a>

<table>
    <thead>
        <th>Nom</th>
        <th colspan="2">Actions</th>
    </thead>
    <tbody>
        <?php foreach( Produit::recupererTous() as $produit ) { ?>
            <tr>
                <td><?php echo $produit->getNom() ?></td>
                <td><a href="<?php echo "modifier.php?idProduit=" . $produit->getId() ?>">Editer</a></td>
                <td><a href="<?php echo "supprimer.php?idProduit=" . $produit->getId() ?>">Editer</a></td>
            </tr>
        <?php } #endforeach ?>
    </tbody>
</table>

<?php

include_once( "end.php" );

?>
