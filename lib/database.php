<?php

function requete_resultats( $sql ) {

    $resultats = array();
    $query = mysql_query( $sql );
    if( !$query ) {
        throw new Exception( "erreur requete $sql : " . mysql_error(), -10 );
    }

    while( $row = mysql_fetch_array( $query ) ) {
        $resultats[] = $row;
    }

    return $resultats;

}

function requete_un_resultat( $sql ) {
    
    $query = mysql_query( $sql );
    if( !$query ) {
        throw new Exception( "erreur requete $sql : " . mysql_error(), -10 );
    }

    return mysql_fetch_array( $query );
}

?>
