<?php
// Disable CSS and JS
add_filter( 'shared_counts_load_css', '__return_false' );
add_filter( 'shared_counts_load_js', '__return_false' );

function etalasepress_shared_counts_header( $output, $location ) {
    if ( 'after_content' === $location ) {
        $output = '<h3>' . __( 'Share this Article', 'etalasepress' ) . '</h3>' . $output;
    }

    return $output;
}

add_filter( 'shared_counts_display', 'etalasepress_shared_counts_header', 10, 2 );

function etalasepress_shared_counts_email_link( $link, $id ) {
    if ( 'email' !== $link['type'] ) {
        return $link;
    }

    $subject = esc_html__( 'Your friend has shared an article with you.', 'etalasepress' );
    $subject = apply_filters( 'shared_counts_amp_email_subject', $subject, $id );
    
    $body = html_entity_decode( get_the_title( $id ), ENT_QUOTES ) . "\r\n";
    $body .= get_permalink( $id ) . "\r\n";
    $body = apply_filters( 'shared_counts_amp_email_body', $body, $id );
    
    $link['link'] = 'mailto:?subject=' . rawurlencode( $subject ) . '&body=' . rawurlencode( $body );

    return $link;
}

add_filter( 'shared_counts_link', 'etalasepress_shared_counts_email_link', 10, 2 );

function etalasepress_shared_counts_services( $services, $location ) {
    if ( 'after_content' !== $location ) {
        return $services;
    }

    foreach ( $services as $i => $service ) {
        if ( 'print' === $service ) {
            unset( $services[$i] );
        }
    }

    return $services;
}

add_filter( 'shared_counts_display_services', 'etalasepress_shared_counts_services', 10, 2 );

function etalasepress_shared_counts_locations( $locations ) {
    $locations['before']['hook'] = 'etalasepress_entry_header_share';
    $locations['after']['hook'] = 'etalasepress_entry_footer_share';
    $locations['after']['style'] = 'button';
    return $locations;
}

add_filter( 'shared_counts_theme_locations', 'etalasepress_shared_counts_locations' );

function etalasepress_production_url( $url = false ) {
    $production = false; // put production URL here

    if ( !empty( $production_url ) ) {
        $url = $url ? esc_url( $url ) : home_url();
        $url = str_replace( home_url(), $production, $url );
    }

    return esc_url( $url );
}

function etalasepress_production_url_share_count_api( $params ) {
    $params['url'] = etalasepress_production_url( $params['url'] );
    return $params;
}

add_filter( 'shared_counts_api_params', 'etalasepress_production_url_share_count_api' );

function etalasepress_production_url_share_count_link( $link ) {
    $exclude = array( 'print', 'email' );
    
    if ( !in_array( $link['type'], $exclude ) ) {
        $link['link'] = etalasepress_production_url( $link['link'] );
    }
    
    return $link;
}

add_filter( 'shared_counts_link', 'etalasepress_production_url_share_count_link' );
