<?php

include_once( "init.php" );
include_once( ROOT . "lib/setup.php" );
include_once( ROOT . "conf/conf.php" );

$etapeActuel = 'creation';

if( isset( $_POST['create'] ) ) {

    $output = createTables( $info_database );
    if( strlen( $output ) == 0 ) {
        header("Location: deployment.php");
    }

}

include_once( "header.php" );

?>

<h2>Création de la base de données</h2>

<?php if( isset( $output ) ) { ?>

    <div class="alert-message block-message error">
        <p>
            Une erreur est survenue lors de la création. Message d'erreur reçu :
            <?php echo $output ?>
        </p>
    </div>

<?php } else if( tableExists( $info_database ) ) { ?>

    <p>
        La base de données semble déja être créee. Par mesure de sécurité, le système de configuration ne tentera pas de les modifier.
        Veuillez recréer la base de données puis recharger cette page si vous voulez reconfigurer le système.
    </p>
    <a href="deployment.php">Passez à l'étape suivante</a>

<?php } else { ?>

    <p>
        Le système procédera maintenant à la création de la base de données.
        Si jamais des erreurs surviennent durant la création, ils seront affichés sur cette page.
        Veuillez cliquer sur le bouton ci-dessous pour continuer
    </p>

    <div class="alert-message block-message warning">
        <p>Si vous avez de la difficulté à créer les procédures SQL, vous pouvez essayer d'activer temporairement cette option dans MySQL en tant que root : </p>
        <pre class='prettyprint'>
            SET GLOBAL log_bin_trust_function_creators = 1;
        </pre>
    </div>

    <form name="creation" action="creation.php" method="post" >
        <div class='actions'>
            <button class="btn primary" name="create">Créer BD</button>
        </div>
    </form>

<?php } #endif ?>

<?php include_once( "end.php" ) ?>
