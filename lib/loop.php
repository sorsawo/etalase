<?php
function etalasepress_default_loop() {
    if ( have_posts() ) :
        tha_content_while_before();

        while ( have_posts() ) : the_post();
            tha_entry_before();

            $partial = apply_filters( 'etalasepress_loop_partial', is_singular() ? 'content' : 'archive'  );
            $context = apply_filters( 'etalasepress_loop_partial_context', is_search() ? 'search' : get_post_type() );
            
            get_template_part( 'partials/' . $partial, $context );

            tha_entry_after();
        endwhile;

        tha_content_while_after();
    else :
        tha_entry_before();
        $context = apply_filters( 'etalasepress_empty_loop_partial_context', 'none' );
        get_template_part( 'partials/archive', $context );
        tha_entry_after();
    endif;
}

add_action( 'tha_content_loop', 'etalasepress_default_loop' );

function etalasepress_entry_title() {
    echo '<h1 class="entry-title">' . get_the_title() . '</h1>';
}

add_action( 'tha_entry_top', 'etalasepress_entry_title' );

function etalasepress_remove_entry_title() {
    if ( !( is_singular() && function_exists( 'parse_blocks' ) ) ) {
        return;
    }

    global $post;
    
    $blocks = parse_blocks( $post->post_content );
    $has_h1 = etalasepress_has_h1_block( $blocks );

    if ( $has_h1 ) {
        remove_action( 'tha_entry_top', 'etalasepress_breadcrumbs', 8 );
        remove_action( 'tha_entry_top', 'etalasepress_entry_category', 8 );
        remove_action( 'tha_entry_top', 'etalasepress_entry_title' );
        remove_action( 'tha_entry_top', 'etalasepress_entry_author', 12 );
        remove_action( 'tha_entry_top', 'etalasepress_entry_header_share', 13 );
    }
}

add_action( 'tha_entry_before', 'etalasepress_remove_entry_title' );

function etalasepress_has_h1_block( $blocks = array() ) {
    foreach ( $blocks as $block ) {
        if ( !isset( $block['blockName'] ) ) {
            continue;
        }

        // Heading block
        if ( 'core/heading' === $block['blockName'] && isset( $block['attrs']['level'] ) && 1 === $block['attrs']['level'] ) {
            return true;
        } elseif ( isset( $block['innerBlocks'] ) && !empty( $block['innerBlocks'] ) ) { // Scan inner blocks for headings
            $inner_h1 = etalasepress_has_h1_block( $block['innerBlocks'] );
            
            if ( $inner_h1 ) {
                return true;
            }
        }
    }

    return false;
}

function etalasepress_comments() {
    if ( is_single() && ( comments_open() || get_comments_number() ) ) {
        comments_template();
    }
}

add_action( 'tha_content_while_after', 'etalasepress_comments' );
