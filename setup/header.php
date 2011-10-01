<?php

$etapes = array(
    'configuration' => 'Configuration BD',
    'creation' => 'Création',
    'deployment' => 'Déploiement',
);

if( !isset( $etapeActuel ) ) {
    $etapeActuel = null;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Configuration Yvon-o-sphere</title>
    <link href="<?php echo ROOT . "css/bootstrap-1.1.0.min.css" ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo ROOT . "css/setup.css" ?>" type="text/css" rel="stylesheet" />
</head>

<body>

<!-- HEADER -->
<div class="title">
    <h1>Configuration de Yvon-O-Sphere</h1>
</div>

<div class="container-fluid">

    <!-- MENU DE GAUCHE -->
    <div class="sidebar">
        <ol>
        <?php foreach( $etapes as $fichier => $nom ) {
            if( $fichier == $etapeActuel ) {
                echo "<li class='selected'>";
            } else {
                echo "<li>";
            }
            echo '<a href="' . $fichier . '">' . $nom . '</a>';
            echo "</li>";
        } ?>
        </ol>
    </div>

    <div class="content">

