<?php

if( !file_exists( "conf/conf.php" ) ) {
    header("Location: setup");
} else {
    include_once( "conf/init.php" );
    include_once( "lib/urls.php" );
    header("Location: " . url( "accueil" ) );
}
?>
