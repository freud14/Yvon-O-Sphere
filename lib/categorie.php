<?php

function getCategories() {

    $sql =<<<EOQ
    SELECT
        id,
        nom
    FROM
        categories
EOQ;

    $query = mysql_query( $sql );
    if( !$query ) {
        die("erreur requete sql : " . mysql_error() );
    }

    $categories = array();
    while( $row = mysql_fetch_assoc( $query ) ) {
        $categories[] = $row;
    }

    return $categories;

}

function listeCategories( $categorie_id = null ) {

    $html = "<select name='categorie_id'>";
    foreach( getCategories() as $categorie ) {

        $html .= "<option ";

        if ( $categorie_id == $categorie['id'] ) {
            $html .= "selected ";
        }

        $html .= " value='" . htmlspecialchars( $categorie['id'] )
            . "'>" . htmlspecialchars( $categorie['nom'] )
            . "</option>";
    }

    $html .= "</select>";

    return $html;
}

?>
