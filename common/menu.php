<?php

$idCategorie = null;

if( isConnected() ) {
    $utilisateur = getUtilisateurConnecte();
    $idCategorie = $utilisateur['categorie_id'];
}

$archives = getArchives( $idCategorie );

?>

<div class="navigation">

    <h1>Menu</h1>

    <ul id="menu" class="menu">
        <?php if( !isConnected() ) { ?>
            <li>
            <a href="<?php echourl( "accueil/connexion.php" ) ?>">Connexion utilisateur</a>
            </li>
        <?php } else { ?>
            <li>
            <a href="<?php echourl( "accueil/deconnexion.php" ) ?>">Déconnexion</a>
            </li>
        <?php } #endif ?>
        <?php if( isConnectedAsAdmin() ) { ?>
            <li>
            <a href="<?php echourl( "admin" ) ?>">Module d'administration</a>
            </li>
        <?php } #endif ?>
    </ul>

    <?php if ( isConnected() ) { ?>
        <h1>Achats</h1>
        <ul>
            <li>
            <a href="<?php echourl( "achat/produit.php" ) ?>">Produits disponibles</a>
            </li>
            <li>
            <a href="<?php echourl( "achat/panier.php" ) ?>">Panier d'achat</a>
            </li>
        </ul>
        <h1>Mon profil</h1>
        <ul>
            <li class="info">
                <b>Nom :</b>
                <?php echo $utilisateur['prenom'] . " " . $utilisateur['nom'] ?>
            </li>
            <li class="info">
                <b>Nom d'utilisateur :</b>
                <?php echo $utilisateur['username'] ?>
            </li>
        </ul>
    <?php
    
    }
    ?>

<?php 

if(isConnected()) { ?>
    <h1>Mon thème</h1>
    <ul>
        <li>
        <form method="POST" action="#">
            <strong>Thème:</strong> 
            <select name="theme">
<?php
    foreach(getThemesDisponibles() as $theme) {
        if($theme == $_SESSION['theme']) {
            echo "\t\t\t<option value=\"".htmlspecialchars($theme)."\" selected=\"selected\">".ucfirst(htmlspecialchars($theme))."</option>\n";
        }
        else {
            echo "\t\t\t<option value=\"".htmlspecialchars($theme)."\">".ucfirst(htmlspecialchars($theme))."</option>\n";
        }
    }
?>
            </select>
            <input class="myButton" type="submit" value="OK" />
        </form>
        </li>
    </ul>
<?php
}

?>

<h1>Site web réalisé par</h1>

<ul id="realisateurs">
    <li>
        <a href="mailto:gzou2000@gmail.com">Gregory Eric Sanderson Turcot Temlett MacDonnell Forbes</a><br />
        <span>
            <b>Twitter:</b> @gelendir<br />
            <b>Facebook:</b> gregory.eric.sanderson<br />
            <b>Reddit:</b> gelendir
        </span>
    </li>
    <li>
        <a href="mailto:fredy_14@live.fr">Frédérik Paradis</a><br />
        <span>
            <b>Facebook:</b> frederik.paradis
        </span>
    </li>
</ul>

<h1 id="archives"><a href="#">Archives</a></h1>
<div id="archive-menu">
    <ul>
    <?php foreach( $archives as $annee => $mois ) { ?>
        <li>
            <a class="annee" href="#"><?php echo $annee ?></a>
            <ul class="archive-mois">
                <?php foreach( $mois as $nbMois ) { 
                    $params = url( "accueil/?mois=" . intval( $nbMois )
                        . "&annee=" . intval( $annee ) );
                ?>
                    <li>
                        <a href="<?php echo $params ?>">
                        <?php echo date( 'F', mktime( 0, 0, 0, $nbMois ) ) ?>
                        </a>
                    </li>
                <?php } #endfor ?>
            </ul>
        </li>
    <?php } #endfor ?>
</div>

</div>
