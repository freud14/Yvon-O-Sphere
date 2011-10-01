<?php

function input( $nom, $label, $valeur, $type='text', $erreurs = null ) {

    echo "<div class=\"clearfix";
    if( $erreurs && array_key_exists( $nom, $erreurs ) ) {
        echo " error";
    }

    echo "\">";

    echo "<label for=\""
        . htmlspecialchars( $nom ) 
        . "\">"
        . htmlspecialchars( $label )
        . "</label>";

    echo "<div class=\"input\">";

    echo "<input type=\"$type\" name=\""
        . htmlspecialchars( $nom )
        . "\" value=\""
        . htmlspecialchars( $valeur )
        . "\" />";

    if( $erreurs && array_key_exists( $nom, $erreurs ) ) {
        echo "<span class='help-inline'>";
        foreach( $erreurs[ $nom ] as $erreur ) {
            echo $erreur . " ";
        }
        echo "</span>";
    }

    echo "</div>";
    echo "</div>";
}

function select( $nom, $label, $valeurs, $selected = null, $erreurs = null ) {

    $html =  "<div class=\"clearfix\">";

    $html .= "<label for=\""
        . htmlspecialchars( $nom ) 
        . "\">"
        . htmlspecialchars( $label )
        . "</label>";

    $html .= "<div class=\"input\">";

    $html .= "<select name='" . htmlspecialchars( $nom ) . "'>";
    foreach( $valeurs as $valeur ) {

        $html .= "<option ";

        if ( $valeur['name'] == $selected ) {
            $html .= "selected ";
        }

        $html .= " value='" . htmlspecialchars( $valeur['value'] )
            . "'>" . htmlspecialchars( $valeur['name'] )
            . "</option>";
    }

    $html .= "</select>";

    $html .= "</div></div>";

    echo $html;

}

?>
