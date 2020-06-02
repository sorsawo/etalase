<?php
if ( !function_exists( 'etalasepress_page_layout' ) ) {
    return;
}

$layout = etalasepress_page_layout();

if ( !in_array( $layout, array( 'content-sidebar', 'sidebar-content' ) ) ) {
    return;
}

do_action( 'etalasepress_sidebar' );
