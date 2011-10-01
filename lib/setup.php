<?php

define( "CONF_FILE", "conf/conf.php" );
define( "TEMPLATE_FILE", "conf/conf.php.tmpl" );

include_once( "helpers.php" );

$TABLES = array(
    'utilisateurs',
    'categories',
    'nouvelles',
    'produits',
    'produits_transactions',
    'transactions',
    'factures',
);

$FICHIERS_SQL = array(
    'sql/tables.sql',
    'sql/categories.sql',
    'sql/procedures_verifier.sql',
    'sql/procedure_produit.sql',
    'sql/procedure_transaction.sql',
    'sql/procedure_produit_transaction.sql',
);

function categorieSelect( $selected = null, $erreurs = null ) {

    $valeurs = array();
    foreach( getCategories() as $categorie ) {
        $valeurs[] = array(
            'name' => $categorie['nom'],
            'value' => $categorie['id'],
        );
    }

    select( "categorie_id", "Catégorie", $valeurs, $selected, $erreurs );

}

function themeSelect( $selected = null, $erreurs = null ) {

    $valeurs = array ();
    foreach( getThemesDisponibles() as $nom_theme ) {
        $valeurs[] = array(
            'name' => ucfirst( $nom_theme ),
            'value' => $nom_theme
        );
    }

    select( "theme", "Thème", $valeurs, $selected, $erreurs );

}

function confExists() {

    return file_exists( ROOT . CONF_FILE );

}

function createConfigFile( $configuration ) {

    if( confExists() ) {
        die("fichier de configuration déja existant");
    }

    $template = file_get_contents( ROOT . TEMPLATE_FILE );
    if( !$template ) {
        die("erreur lors de la lecture du fichier template de configuration. veuillez vérifier les permissions fichiers");
    }


    foreach( $configuration as $key => $value ) {
        $token = "%" . $key . "%";
        $template = str_replace( $token, $value, $template );
    }

    $result = file_put_contents( ROOT . CONF_FILE, $template );

    if( !$result ) {
        die("erreur lors de la création du fichier de configuration. veuillez vérifier les permissions fichiers");
    }

}

function testDatabaseConnection( $config ) {

    $conn = @mysql_connect(
        $config['db_host'],
        $config['db_username'],
        $config['db_password']
    );

    if( !$conn ) {
        return false;
    }

    $db = @mysql_select_db( $config['db_name'] );

    return $db;

}

function testPaths( $config ) {

    if( !is_dir( $config['path_upload'] ) ) {
        $created = @mkdir( $config['path_upload'] );
        if( !$created ) {
            return -2;
        }
    }

    if( !is_writable( $config['path_upload'] ) ) {
        return -1;
    }

    return true;

}

function createTables( $config ) {

    global $FICHIERS_SQL;

    $base_command = "mysql --user=\""
        . addslashes( $config['user'] )
        . "\" --password=\""
        . addslashes( $config['password'] )
        . "\" \"" . $config['database']
        . "\" < \"";

    foreach( $FICHIERS_SQL as $file ) {

        $command = $base_command
            . addslashes( $_SERVER['DOCUMENT_ROOT'] . URL_ROOT . $file  )
            . "\" 2>&1";

        $output = shell_exec( $command );

        if( strlen( $output ) != 0 ) {
            return $output;
        }

    }

    return $output;

}

function initDb( $config ) {

    mysql_connect(
        $config['server'],
        $config['user'],
        $config['password']
    );

    mysql_select_db( $config['database'] );

}

function tableExists( $config ) {

    global $TABLES;

    $tables = array();

    initDb( $config );

    $sql = "SHOW TABLES FROM " . $config['database'];

    $query = mysql_query( $sql );
    if( !$query ) {
        die("erreur recuperation list tables : " . mysql_error() );
    }

    while( $row = mysql_fetch_row( $query ) ){
        $tables[] = $row[0];
    }

    return ( count( $tables ) == count( $TABLES ) );

}

?>
