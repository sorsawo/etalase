<?php
function etalasepress_register_required_plugins() {
    $config = array(
        'has_notices' => false
    );
    
    $plugins = apply_filters( 'etalasepress_required_plugins', array(
        array(
            'name'     => 'Core Functionality',
            'slug'     => 'core-functionality',
            'source'   => 'https://github.com/sorsawo/core-functionality/archive/master.zip',
            'required' => true,
        ),
        array(
            'name'     => 'WordPress SEO by Yoast',
            'slug'     => 'wordpress-seo',
            'required' => false,
        ),
        array(
            'name'     => 'WPForms Lite',
            'slug'     => 'wpforms-lite',
            'required' => false,
        ),
        array(
            'name'     => 'Shared Counts',
            'slug'     => 'shared-counts',
            'required' => false,
        ),
        array(
            'name'     => 'MailChimp for WP',
            'slug'     => 'mailchimp-for-wp',
            'required' => false,
        ),
        array(
            'name'     => 'Antispam Bee',
            'slug'     => 'antispam-bee',
            'required' => false,
        ),
        array(
            'name'     => 'iThemes Security',
            'slug'     => 'better-wp-security',
            'required' => false,
        ),
        array(
            'name'     => 'WP Mail SMTP',
            'slug'     => 'wp-mail-smtp',
            'required' => false,
        ),
        array(
            'name'     => 'WP Super Cache',
            'slug'     => 'wp-super-cache',
            'required' => false,
        ),
    ) );

    tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'etalasepress_register_required_plugins' );

function etalasepress_color_scheme_body_class( $classes ) {
    $color_scheme = get_theme_mod( 'etalasepress_color_scheme', 'default' );
    
    if ( 'default' !== $color_scheme ) {
        $classes[] = $color_scheme;
    }

    return $classes;
}

add_filter( 'body_class', 'etalasepress_color_scheme_body_class', 6 );
