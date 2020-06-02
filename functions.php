<?php
include_once get_template_directory() . '/lib/init.php';

function alamanda_scripts() {
    if ( !alamanda_is_amp() ) {
        wp_enqueue_script( 'alamanda-global', get_template_directory_uri() . '/assets/js/global-min.js', array( 'jquery' ), filemtime( get_template_directory() . '/assets/js/global-min.js' ), true );
        wp_enqueue_script( 'alamanda-smoothscroll', get_template_directory_uri() . '/assets/js/smoothscroll-min.js', array( 'jquery' ), filemtime( get_template_directory() . '/assets/js/smoothscroll-min.js' ), true );

        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }

    wp_enqueue_style( 'alamanda-fonts', alamanda_theme_fonts_url() );
    wp_enqueue_style( 'alamanda-style', get_template_directory_uri() . '/assets/css/main.css', array(), filemtime( get_template_directory() . '/assets/css/main.css' ) );
}

add_action( 'wp_enqueue_scripts', 'alamanda_scripts' );

function alamanda_gutenberg_scripts() {
    wp_enqueue_style( 'alamanda-fonts', alamanda_theme_fonts_url() );
    wp_enqueue_script( 'alamanda-editor', get_template_directory_uri() . '/assets/js/editor.js', array( 'wp-blocks', 'wp-dom' ), filemtime( get_template_directory() . '/assets/js/editor.js' ), true );
}

add_action( 'enqueue_block_editor_assets', 'alamanda_gutenberg_scripts' );

function alamanda_theme_fonts_url() {
    return apply_filters( 'alamanda_fonts_url', '//fonts.googleapis.com/css?family=Work+Sans:700' );
}

if ( !function_exists( 'alamanda_setup' ) ) :

    function alamanda_setup() {
        /*
         * Make theme available for translation.
         */
        load_theme_textdomain( 'alamanda', get_template_directory() . '/languages' );

        // Editor Styles
        add_theme_support( 'editor-styles' );
        add_editor_style( 'assets/css/editor-style.css' );

        // Admin Bar Styling
        add_theme_support( 'admin-bar', array( 'callback' => '__return_false' ) );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        // Body open hook
        add_theme_support( 'body-open' );

        // Let WordPress manage the document title.
        add_theme_support( 'title-tag' );

        // Set the content width in pixels, based on the theme's design and stylesheet.
        $GLOBALS['content_width'] = apply_filters( 'alamanda_content_width', 768 );

        // Enable support for Post Thumbnails on posts and pages.
        add_theme_support( 'post-thumbnails' );

        // This theme uses wp_nav_menu() in two location.
        register_nav_menus( array(
            'primary'   => esc_html__( 'Primary Navigation Menu', 'alamanda' ),
            'secondary' => esc_html__( 'Secondary Navigation Menu', 'alamanda' ),
            'footer'    => esc_html__( 'Footer Navigation Menu', 'alamanda' ),
        ) );

        // HTML5 Support
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );
        
        add_theme_support(
            'custom-logo', array(
                'height'      => 62,
                'width'       => 300,
                'flex-height' => false,
                'flex-width'  => false,
            )
        );

        // Gutenberg Responsive embeds
        add_theme_support( 'responsive-embeds' );

        // Gutenberg Wide Images
        add_theme_support( 'align-wide' );

        // Gutenberg Disable custom font sizes
        add_theme_support( 'disable-custom-font-sizes' );

        // Gutenberg Editor Font Styles
        add_theme_support( 'editor-font-sizes', array(
            array(
                'name'      => __( 'Small', 'alamanda' ),
                'shortName' => __( 'S', 'alamanda' ),
                'size'      => 14,
                'slug'      => 'small'
            ),
            array(
                'name'      => __( 'Normal', 'alamanda' ),
                'shortName' => __( 'M', 'alamanda' ),
                'size'      => 20,
                'slug'      => 'normal'
            ),
            array(
                'name'      => __( 'Large', 'alamanda' ),
                'shortName' => __( 'L', 'alamanda' ),
                'size'      => 24,
                'slug'      => 'large'
            ),
        ) );

        // Gutenberg Disable Custom Colors
        add_theme_support( 'disable-custom-colors' );

        // Gutenberg Editor Color Palette
        add_theme_support( 'editor-color-palette', array(
            array(
                'name'  => __( 'Dark Blue', 'alamanda' ),
                'slug'  => 'dark-blue',
                'color' => '#003396',
            ),
            array(
                'name'  => __( 'Light Blue', 'alamanda' ),
                'slug'  => 'light-blue',
                'color' => '#94A4EF',
            ),
            array(
                'name'  => __( 'Dark Red', 'alamanda' ),
                'slug'  => 'dark-red',
                'color' => '#991101',
            ),
            array(
                'name'  => __( 'Brown', 'alamanda' ),
                'slug'  => 'brown',
                'color' => '#994C01',
            ),
            array(
                'name'  => __( 'Light Red', 'alamanda' ),
                'slug'  => 'light-red',
                'color' => '#FFF5F4',
            ),
            array(
                'name'  => __( 'Light Green', 'alamanda' ),
                'slug'  => 'light-green',
                'color' => '#B7FFBF',
            ),
            array(
                'name'  => __( 'Dark Gray', 'alamanda' ),
                'slug'  => 'dark-gray',
                'color' => '#333333',
            ),
            array(
                'name'  => __( 'Medium Gray', 'alamanda' ),
                'slug'  => 'medium-gray',
                'color' => '#999999',
            ),
            array(
                'name'  => __( 'Coffee', 'alamanda' ),
                'slug'  => 'coffee',
                'color' => '#E4E3D8',
            ),
            array(
                'name'  => __( 'Light Gray', 'alamanda' ),
                'slug'  => 'light-gray',
                'color' => '#f5f5f5',
            )
        ) );
    }

endif;

add_action( 'after_setup_theme', 'alamanda_setup' );

function alamanda_template_hierarchy( $template ) {
    if ( is_home() || is_search() ) {
        $template = get_query_template( 'archive' );
    }
    
    return $template;
}

add_filter( 'template_include', 'alamanda_template_hierarchy' );
