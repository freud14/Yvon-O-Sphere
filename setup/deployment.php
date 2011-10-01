<?php

include_once( "init.php" );
include_once( ROOT . "lib/categorie.php" );
include_once( ROOT . "lib/utilisateur.php" );
include_once( ROOT . "lib/theme.php" );
include_once( ROOT . "lib/setup.php" );
include_once( ROOT . "lib/urls.php" );
include_once( ROOT . "conf/conf.php" );

initDb( $info_database );

$etapeActuel = 'deployment';

$administrateur = array(
    'username' => '',
    'nom' => '',
    'prenom' => '',
    'categorie_id' => '',
    'password' => '',
    'passwordConfirm' => '',
    'theme' => '',
);

$erreurs = null;

if( isset( $_POST['create'] ) ) {

    $administrateur = $_POST;
    $administrateur['admin'] = true;

    $erreurs = validerUtilisateur( $administrateur );

    if( count( $erreurs ) == 0 ) {

        creerUtilisateur( $administrateur );
        header("Location: " . url( "accueil/connexion.php" ) );

    }

}

include_once( "header.php" );

?>

<h2>Création compte administrateur</h2>

<p>Il est maintenant venu le temps de créer le compte administrateur. Une fois créee, vous serez redirigé vers la page d'authenthification où vous pourrez accèder au paneau d'administration du blogue.</p>

<form name="deployment" action="deployment.php" method="post">

    <fieldset class="form">

        <legend>Compte administrateur</legend>

        <?php input( 'username', "Nom d'utilisateur", $administrateur['username'], 'text', $erreurs ) ?>

        <?php input( 'nom', "Nom", $administrateur['nom'], 'text', $erreurs ) ?>

        <?php input( 'prenom', "Prénom", $administrateur['prenom'], 'text', $erreurs ) ?>

        <?php input( 'password', "Mot de passe", $administrateur['password'], 'password', $erreurs ) ?>

        <?php input( 'passwordConfirm', "Confirmer mot de passe", $administrateur['passwordConfirm'], 'password', $erreurs ) ?>

        <?php categorieSelect( $administrateur['categorie_id'], $erreurs ) ?>

        <?php themeSelect( $administrateur['theme'], $erreurs ) ?>

        <div class='actions'>
            <button class="btn primary" name="create">Créer Administrateur</button>
        </div>

    </fieldset>

</form>

<?php include_once( "end.php" ) ?>

