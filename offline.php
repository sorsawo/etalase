<?php
// Offline Content
function etalasepress_pwa_offline_content() {
    echo '<h1>' . __( 'Oops, it looks like you\'re offline', 'etalasepress' ) . '</h1>';
    
    if ( function_exists( 'wp_service_worker_error_message_placeholder' ) ) {
        wp_service_worker_error_message_placeholder();
    }
}

add_action( 'tha_content_loop', 'etalasepress_pwa_offline_content' );

remove_action( 'tha_content_loop', 'etalasepress_default_loop' );

// Build the page
require get_template_directory() . '/index.php';
