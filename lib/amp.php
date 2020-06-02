<?php
function etalasepress_is_amp() {
    return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
}

function etalasepress_wpforms_amp_support( $is_pro ) {
    if ( etalasepress_is_amp() ) {
        $is_pro = false;
    }

    return $is_pro;
}

add_filter( 'wpforms_amp_pro', 'etalasepress_wpforms_amp_support' );

function etalasepress_amp_class( $default, $active, $state ) {
    $output = '';

    if ( etalasepress_is_amp() ) {
        $output .= sprintf( ' [class]="%s"', esc_attr( sprintf( '%s ? \'%s\' : \'%s\'', $state, $default . ' ' . $active, $default ) ) );
    }

    $output .= sprintf( ' class="%s"', esc_attr( $default ) );

    return $output;
}

function etalasepress_amp_toggle( $state = '', $disable = array() ) {
    if ( !etalasepress_is_amp() ) {
        return;
    }

    $settings = sprintf( '%1$s: ! %1$s', esc_js( $state ) );

    if ( !empty( $disable ) ) {
        foreach ( $disable as $disableState ) {
            $settings .= sprintf( ', %s: false', esc_js( $disableState ) );
        }
    }

    return sprintf( ' on="tap:AMP.setState({%s})"', $settings );
}

function etalasepress_amp_nav_dropdown( $theme_location = false, $depth = 0 ) {
    $key = 'nav';
    
    if ( !empty( $theme_location ) ) {
        $key .= ucwords( $theme_location );
    }

    global $submenu_index;
    
    $submenu_index++;
    
    $key .= 'SubmenuExpanded' . $submenu_index;

    if ( 1 < $depth ) {
        $key .= 'Depth' . $depth;
    }

    return etalasepress_amp_toggle( $key ) . etalasepress_amp_class( 'submenu-expand', 'expanded', $key );
}
