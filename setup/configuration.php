<?php

$etapeActuel = 'configuration';

$configuration = array(
    'db_username' => '',
    'db_password' => '',
    'db_name' => 'blogue',
    'db_host' => 'localhost',
    'path_url_root' => '/',
    'path_upload' => $_SERVER['DOCUMENT_ROOT'] . "/uploads",
);

include_once("init.php");
include_once( ROOT . "lib/setup.php" );

function showPathMessages( $status ) {

    if( $status === true ) {
        echo '<div class="alert-message block-message success">';
    } else {
        echo '<div class="alert-message block-message error">';
    }

    if( $status === true ) {
        $message = "Les chemins d'accès sont disponibles";
    } else if ( $status == -1 ) {
        $message = "Le système n'a pas d'accès en écriture au dossier d'images. Veuillez vérifier les permissions du dossier";
    } else if ( $status == -2 ) {
        $message = "Le système est incapable de créer le dossier d'images. Veuillez créer le dossier ou ajuster les permissions.";
    }

    echo "<p>" . $message . "</p>";
    echo "</div>";

}

function showConnectionMessages( $status ) {

    if( $status == true ) {
        echo '<div class="alert-message block-message success">';
    } else {
        echo '<div class="alert-message block-message error">';
    }

    if( $status == true ) {
        $message = "La connexion a été effectué avec succès";
    } else {
        $message = "Une erreur est survenue lors de la connexion à la base de données. Veuillez vérifier vos paramètres. Dernier message d'erreur MySQL :";
        $message .= mysql_error();
    }

    echo "<p>" . $message . "</p>";
    echo "</div>";
}

if( isset( $_POST['testdb'] ) ) {

    $configuration = $_POST;
    $connectionTest = testDatabaseConnection( $configuration );

} else if ( isset( $_POST['testpath'] ) ) {

    $configuration = $_POST;
    $pathTest = testPaths( $configuration );

} else if ( isset( $_POST['save'] ) ) {

    $configuration = $_POST;
    $connectionTest = testDatabaseConnection( $configuration );
    $pathTest = testPaths( $configuration );

    if( $connectionTest === true && $pathTest === true ) {
        createConfigFile( $configuration );
        header('Location: creation.php');
    }

}

include_once("header.php"); 

?>

<h2>Configuration de la base de données</h2>

<?php if( confExists() ) { ?>

    <p>
        Le fichier de configuration semble déja être mis en place. Par mesure de sécurité, le système de configuration ne tentera pas de le modifier.
        Veuillez effacer le fichier <?php echo CONF_FILE ?> puis recharger cette page si vous voulez reconfigurer le système.
    </p>
    <a href="creation.php">Passez à l'étape suivante</a>

<?php } else { ?>

    <p>
        Avant de remplir les champs, veuillez vous assurer d'avoir crée le compte utilisateur
        ainsi que la base de données. Pour ce faire, vous pouvez vous inspirer des commandes SQL
        ci-bas:
    </p>
    <pre class="prettyprint">
        CREATE DATABASE blogue CHARACTER SET 'utf8' DEFAULT COLLATE 'utf_general_ci';
        GRANT ALL PRIVILEGES ON blogue.* TO 'utilisateur'@'localhost' IDENTIFIED BY 'password';
    </pre>

    <?php if( isset( $connectionTest ) ) { ?>
        <?php showConnectionMessages( $connectionTest ) ?>
    <?php } if ( isset( $pathTest ) ) { ?>
        <?php showPathMessages( $pathTest ) ?>
    <?php } #endif ?>

    <form name="configuration" method="post" action="configuration.php">

        <fieldset class='form'>

            <legend>Base de données</legend>

            <?php input( 'db_username', "Nom d'utilisateur", $configuration['db_username'] ) ?>

            <?php input( 'db_password', "Mot de passe", $configuration['db_password'], 'password' ) ?>

            <?php input( 'db_name', "Nom de la base de données", $configuration['db_name'] ) ?>

            <?php input( 'db_host', "Adresse IP", $configuration['db_host'] ) ?>


        </fieldset>

        <fieldset class='form'>

            <legend>Chemin d'accès</legend>

            <?php input( 'path_url_root', "URL Racine", $configuration['path_url_root'] ) ?>

            <?php input( 'path_upload', "Dossier de stockage des images", $configuration['path_upload'] ) ?>

            <div class='actions'>
                <button class="btn primary" name="save">Enregistrer</button>
                <button class="btn info" name="testdb">Tester la connexion BD</button>
                <button class="btn info" name="testpath">Tester les chemins d'accès</button>
            </div>

        </fieldset>
    </form>

<?php } #endif ?>

<?php include_once("end.php") ?>

