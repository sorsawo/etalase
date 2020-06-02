<?php
if ( !function_exists( 'alamanda_page_layout' ) ) {
    return;
}

$layout = alamanda_page_layout();

if ( !in_array( $layout, array( 'content-sidebar', 'sidebar-content' ) ) ) {
    return;
}

do_action( 'alamanda_sidebar' );
