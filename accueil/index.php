<?php

include_once("init.php");

$idCategorie = null;

if( isConnected() ) {
    $utilisateur = getUtilisateurConnecte();
    $idCategorie = $utilisateur['categorie_id'];
}

$archives = getArchives( $idCategorie );

$actualites = array();

$page = 1;
if(isset($_GET['page'])) {
    $page = intval($_GET['page']);
}

$date_actuelle = getdate();
$mois = intval($date_actuelle['month']);
$annee = intval($date_actuelle['year']);

if(isset($_GET['mois']) && isset($_GET['annee'])) {
    $mois = intval($_GET['mois']);
    $annee = intval($_GET['annee']);
    $actualites = getActualites($idCategorie, $page, $mois, $annee);
}
else {
    $actualites = getActualites($idCategorie, $page);
}
?>

<div class="main">

    <?php
        if(count($actualites) == 0) { ?>
        
        <div class="item">
            <div class="date">
            </div>
            <div class="content">
                <h1></h1>
                <div class="body">
                    <p>
                        <strong>Il n'y a aucune nouvelle pour le mois demandé.</strong>
                    </p>
                </div>
            </div>
        </div>
        <?php 
        }
        else{
        ?>
        <?php 
            foreach( $actualites as $nouvelle ) { ?>

        <div class="item">
            <div class="date">
                <div><?php echo date( 'M', $nouvelle['date_parution'] ) ?></div>
                <span><?php echo date( 'j', $nouvelle['date_parution'] ) ?></span>
            </div>
            <div class="content">
                <h1>
                    <?php echo $nouvelle['nom'] ?>
                </h1>
                <div class="body">
                    <p>
                        <?php echo $nouvelle['contenu'] ?>
                    </p>
                </div>
            </div>
        </div>

        <?php } #endfor ?>

        <div class="item_page">
            <div class="content">
                <h1>Page:</h1>
                <div class="body">
                    <p><?php
                        $nb_page = getMaximumPages($idCategorie, $mois, $annee);
                        if(isset($_GET['mois']) && isset($_GET['annee'])) {
                            if($nb_page != 0)
                                $params = "?mois=" . $mois . "&annee=" . $annee . "&page=1";
                                echo '<a href="' . $params . '">1</a>';
                            for($i = 2; $i <= $nb_page; ++$i) {
                                $params = "?mois=" . $mois . "&annee=" . $annee . "&page=" . $i;
                                echo ' <a href="' . $params . '">' . $i . '</a>';
                            }
                        }
                        else {
                            if($nb_page != 0)
                                echo "<a href=\""
                                    . "?page=1"
                                    . "\">1</a>";
                            for($i = 2; $i <= $nb_page; ++$i) {
                                echo " <a href=\""
                                    . "?page=" . $i
                                    . "\">" . $i . "</a>";
                            }
                        }
                    ?></p>
                </div>
            </div>
        </div>
    <?php } #endif ?>
</div>

<?php include_once( ROOT . "common/menu.php" ) ?>

<?php include_once("end.php") ?>

