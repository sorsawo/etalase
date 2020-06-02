<?php
function alamanda_layout_editor_class( $classes ) {
    $screen = get_current_screen();

    if ( ! $screen->is_block_editor() ) {
        return $classes;
    }

    $post_id = isset( $_GET['post'] ) ? intval( $_GET['post'] ) : false;
    $layout = alamanda_page_layout( $post_id );
    $classes .= ' ' . $layout . ' ';

    return $classes;
}

add_filter( 'admin_body_class', 'alamanda_layout_editor_class' );

function alamanda_editor_layout_style() {
    wp_enqueue_style( 'altair-editor-layout', get_stylesheet_directory_uri() . '/assets/css/editor-layout.css', [], filemtime( get_stylesheet_directory() . '/assets/css/editor-layout.css' ) );
}

add_action( 'enqueue_block_editor_assets', 'alamanda_editor_layout_style' );

function alamanda_widgets_init() {
    register_sidebar( alamanda_widget_area_args( array(
        'name' => esc_html__( 'Primary Sidebar', 'alamanda' ),
    ) ) );
}

add_action( 'widgets_init', 'alamanda_widgets_init' );

function alamanda_layout_body_class( $classes ) {
    $classes[] = alamanda_page_layout();

    return $classes;
}

add_filter( 'body_class', 'alamanda_layout_body_class', 5 );

function alamanda_page_layout_options() {
    return array(
        'content-sidebar',
        'sidebar-content',
        'content',
        'full-width-content',
    );
}

function alamanda_widget_area_args( $args = array() ) {
    $defaults = array(
        'name'          => '',
        'id'            => '',
        'description'   => '',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    );

    $args = wp_parse_args( $args, $defaults );

    if ( !empty( $args['name'] ) && empty( $args['id'] ) ) {
        $args['id'] = sanitize_title_with_dashes( $args['name'] );
    }

    return $args;
}

function alamanda_page_layout( $id = false ) {

    $available_layouts = alamanda_page_layout_options();
    
    $layout = get_theme_mod( 'alamanda_default_layout', 'content-sidebar' );

    if ( is_singular() || $id ) {
        $id = $id ? intval( $id ) : get_the_ID();
        $selected = get_post_meta( $id, '_alamanda_page_layout', true );
        
        if ( !empty( $selected ) && in_array( $selected, $available_layouts ) ) {
            $layout = $selected;
        }
    }

    $layout = apply_filters( 'alamanda_page_layout', $layout );
    $layout = in_array( $layout, $available_layouts ) ? $layout : $available_layouts[0];

    return sanitize_title_with_dashes( $layout );
}

function alamanda_return_full_width_content() {
    return 'full-width-content';
}

function alamanda_return_content_sidebar() {
    return 'content-sidebar';
}

function alamanda_return_sidebar_content() {
    return 'sidebar-content';
}

function alamanda_return_content() {
    return 'content';
}

function alamanda_do_sidebar() {
    $sidebar = 'primary-sidebar';
    $display = is_active_sidebar( $sidebar );

    if ( !apply_filters( 'alamanda_display_sidebar', $display ) ) {
        return;
    }

    tha_sidebars_before();

    echo '<aside class="sidebar-primary" role="complementary">';
    tha_sidebar_top();

    if ( is_active_sidebar( $sidebar ) ) {
        dynamic_sidebar( $sidebar );
    }

    tha_sidebar_bottom();
    echo '</aside>';

    tha_sidebars_after();
}

add_action( 'alamanda_sidebar', 'alamanda_do_sidebar' );
