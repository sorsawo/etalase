<?php
global $wp_embed;

add_filter( 'alamanda_the_content', array( $wp_embed, 'run_shortcode' ), 8 );
add_filter( 'alamanda_the_content', array( $wp_embed, 'autoembed' ), 8 );
add_filter( 'alamanda_the_content', 'wptexturize' );
add_filter( 'alamanda_the_content', 'convert_chars' );
add_filter( 'alamanda_the_content', 'wpautop' );
add_filter( 'alamanda_the_content', 'shortcode_unautop' );
add_filter( 'alamanda_the_content', 'do_shortcode' );

function alamanda_first_term( $args = [ ] ) {
    $defaults = [
        'taxonomy' => 'category',
        'field'    => null,
        'post_id'  => null,
    ];

    $args = wp_parse_args( $args, $defaults );

    $post_id = !empty( $args['post_id'] ) ? intval( $args['post_id'] ) : get_the_ID();
    $field = !empty( $args['field'] ) ? esc_attr( $args['field'] ) : false;
    $term = false;

    // Use WP SEO Primary Term
    // from https://github.com/Yoast/wordpress-seo/issues/4038
    if ( class_exists( 'WPSEO_Primary_Term' ) ) {
        $term = get_term( ( new WPSEO_Primary_Term( $args['taxonomy'], $post_id ) )->get_primary_term(), $args['taxonomy'] );
    }

    // Fallback on term with highest post count
    if ( !$term || is_wp_error( $term ) ) {
        $terms = get_the_terms( $post_id, $args['taxonomy'] );

        if ( empty( $terms ) || is_wp_error( $terms ) ) {
            return false;
        }

        // If there's only one term, use that
        if ( 1 == count( $terms ) ) {
            $term = array_shift( $terms );
        } else { // If there's more than one...
            // Sort by term order if available
            // @uses WP Term Order plugin
            if ( isset( $terms[0]->order ) ) {
                $list = array();
                
                foreach ( $terms as $term ) {
                    $list[$term->order] = $term;
                }
                
                ksort( $list, SORT_NUMERIC );
            } else { // Or sort by post count
                $list = array();
                
                foreach ( $terms as $term ) {
                    $list[$term->count] = $term;
                }
                
                ksort( $list, SORT_NUMERIC );
                $list = array_reverse( $list );
            }

            $term = array_shift( $list );
        }
    }

    // Output
    if ( !empty( $field ) && isset( $term->$field ) ) {
        return $term->$field;
    } else {
        return $term;
    }
}

function alamanda_class( $base_classes, $optional_class, $conditional ) {
    return $conditional ? $base_classes . ' ' . $optional_class : $base_classes;
}

function alamanda_bg_image_style( $image_id = false, $image_size = 'full' ) {
    if ( !empty( $image_id ) ) {
        return ' style="background-image: url(' . wp_get_attachment_image_url( $image_id, $image_size ) . ');"';
    }
}

function alamanda_icon( $atts = array() ) {
    $atts = shortcode_atts( array(
        'icon'  => false,
        'group' => 'utility',
        'size'  => 16,
        'class' => false,
        'label' => false,
    ), $atts );

    if ( empty( $atts['icon'] ) ) {
        return;
    }

    $response = wp_remote_get( get_template_directory_uri() . '/assets/icons/' . $atts['group'] . '/' . $atts['icon'] . '.svg' );
    
    if ( is_array( $response ) && ! is_wp_error( $response ) ) {
        $icon = $response['body'];
    } else {
        return;
    }

    $class = 'svg-icon';

    if ( !empty( $atts['class'] ) ) {
        $class .= ' ' . esc_attr( $atts['class'] );
    }

    if ( false !== $atts['size'] ) {
        $repl = sprintf( '<svg class="' . $class . '" width="%d" height="%d" aria-hidden="true" role="img" focusable="false" ', $atts['size'], $atts['size'] );
        $svg = preg_replace( '/^<svg /', $repl, trim( $icon ) ); // Add extra attributes to SVG code.
    } else {
        $svg = preg_replace( '/^<svg /', '<svg class="' . $class . '"', trim( $icon ) );
    }

    $svg = preg_replace( "/([\n\t]+)/", ' ', $svg ); // Remove newlines & tabs.
    $svg = preg_replace( '/>\s*</', '><', $svg ); // Remove white space between SVG tags.

    if ( !empty( $atts['label'] ) ) {
        $svg = str_replace( '<svg class', '<svg aria-label="' . esc_attr( $atts['label'] ) . '" class', $svg );
        $svg = str_replace( 'aria-hidden="true"', '', $svg );
    }

    return $svg;
}

function alamanda_has_action( $hook ) {
    ob_start();
    do_action( $hook );
    $output = ob_get_clean();
    return !empty( $output );
}

function alamanda_breadcrumbs() {
    if ( function_exists( 'yoast_breadcrumb' ) ) {
        yoast_breadcrumb( '<p id="breadcrumbs" class="breadcrumb">', '</p>' );
    }
}
