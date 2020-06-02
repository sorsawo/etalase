<?php

function alamanda_dont_update_theme( $r, $url ) {
    if ( 0 !== strpos( $url, 'https://api.wordpress.org/themes/update-check/1.1/' ) ) {
        return $r; // Not a theme update request. Bail immediately.
    }

    $themes = json_decode( $r['body']['themes'] );
    $parent = get_option( 'template' );
    $child = get_option( 'stylesheet' );

    unset( $themes->themes->$parent );
    unset( $themes->themes->$child );

    $r['body']['themes'] = json_encode( $themes );

    return $r;
}

add_filter( 'http_request_args', 'alamanda_dont_update_theme', 5, 2 );

function alamanda_header_meta_tags() {
    echo '<meta charset="' . get_bloginfo( 'charset' ) . '">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<link rel="profile" href="http://gmpg.org/xfn/11">';
}

add_action( 'wp_head', 'alamanda_header_meta_tags' );

function alamanda_dequeue_jquery_migrate( &$scripts ) {
    if ( !is_admin() ) {
        $scripts->remove( 'jquery' );
        $scripts->add( 'jquery', false, array( 'jquery-core' ), '1.10.2' );
    }
}

add_filter( 'wp_default_scripts', 'alamanda_dequeue_jquery_migrate' );

function alamanda_singular_body_class( $classes ) {
    if ( is_singular() ) {
        $classes[] = 'singular';
    }

    return $classes;
}

add_filter( 'body_class', 'alamanda_singular_body_class' );

function alamanda_clean_body_classes( $classes ) {
    $allowed_classes = [
        'singular',
        'single',
        'page',
        'archive',
        'admin-bar',
        'full-width-content',
        'content-sidebar',
        'sidebar-content',
        'content',
        'black',
        'blue',
        'green',
        'red',
        'orange',
    ];

    return array_intersect( $classes, $allowed_classes );
}

add_filter( 'body_class', 'alamanda_clean_body_classes', 20 );

function alamanda_clean_nav_menu_classes( $classes ) {
    if ( !is_array( $classes ) ) {
        return $classes;
    }

    foreach ( $classes as $i => $class ) {
        // Remove class with menu item id
        $id = strtok( $class, 'menu-item-' );

        if ( 0 < intval( $id ) ) {
            unset( $classes[$i] );
        }

        // Remove menu-item-type-*
        if ( false !== strpos( $class, 'menu-item-type-' ) ) {
            unset( $classes[$i] );
        }

        // Remove menu-item-object-*
        if ( false !== strpos( $class, 'menu-item-object-' ) ) {
            unset( $classes[$i] );
        }

        // Change page ancestor to menu ancestor
        if ( 'current-page-ancestor' == $class ) {
            $classes[] = 'current-menu-ancestor';
            unset( $classes[$i] );
        }
    }

    // Remove submenu class if depth is limited
    if ( isset( $args->depth ) && 1 === $args->depth ) {
        $classes = array_diff( $classes, array( 'menu-item-has-children' ) );
    }

    return $classes;
}

add_filter( 'nav_menu_css_class', 'alamanda_clean_nav_menu_classes', 5 );

function alamanda_clean_post_classes( $classes ) {
    if ( !is_array( $classes ) ) {
        return $classes;
    }

    $allowed_classes = array(
        'hentry',
        'type-' . get_post_type(),
    );

    return array_intersect( $classes, $allowed_classes );
}

add_filter( 'post_class', 'alamanda_clean_post_classes', 5 );

function alamanda_archive_title_remove_prefix( $title ) {
    $title_pieces = explode( ': ', $title );

    if ( count( $title_pieces ) > 1 ) {
        unset( $title_pieces[0] );
        $title = join( ': ', $title_pieces );
    }

    return $title;
}

add_filter( 'get_the_archive_title', 'alamanda_archive_title_remove_prefix' );

function alamanda_staff_comment_class( $classes, $class, $comment_id, $comment, $post_id ) {
    if ( empty( $comment->user_id ) ) {
        return $classes;
    }

    $staff_roles = array( 'comment_manager', 'author', 'editor', 'administrator' );
    $staff_roles = apply_filters( 'alamanda_staff_roles', $staff_roles );
    $user = get_userdata( $comment->user_id );

    if ( !empty( array_intersect( $user->roles, $staff_roles ) ) ) {
        $classes[] = 'staff';
    }

    return $classes;
}

add_filter( 'comment_class', 'alamanda_staff_comment_class', 10, 5 );

function alamanda_remove_avatars_from_comments( $avatar ) {
    global $in_comment_loop;
    return $in_comment_loop ? '' : $avatar;
}

add_filter( 'get_avatar', 'alamanda_remove_avatars_from_comments' );

function alamanda_comment_form_button_class( $args ) {
    $args['class_submit'] = 'submit wp-block-button__link';
    return $args;
}

add_filter( 'comment_form_defaults', 'alamanda_comment_form_button_class' );

function alamanda_excerpt_more() {
    return '&hellip;';
}

add_filter( 'excerpt_more', 'alamanda_excerpt_more' );

remove_action( 'wp_print_styles', 'print_emoji_styles' );
