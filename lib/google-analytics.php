<?php
function alamanda_google_analytics_code() {
    $tracking_id = alamanda_get_setting_value( 'google_analytics_id' );
    
    if ( '' !== $tracking_id ) {
        echo '<script async src="https://www.googletagmanager.com/gtag/js?id=' . $tracking_id . '"></script>', "\n";
        echo '<script>', "\n";
        echo 'window.dataLayer = window.dataLayer || [];', "\n";
        echo 'function gtag(){dataLayer.push(arguments);}', "\n";
        echo "gtag('js', new Date());", "\n";
        echo "gtag('config', '" . $tracking_id . "');", "\n";
        echo '</script>';
    }
}

add_action( 'wp_head', 'alamanda_google_analytics_code', 99 );