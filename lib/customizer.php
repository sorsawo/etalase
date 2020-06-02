<?php

function etalasepress_customize_register( $wp_customize ) {
    if ( in_array( 'login-logo', etalasepress_get_setting_value( 'modules' ) ) ) {
        $wp_customize->add_setting( 'etalasepress_login_image', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'etalasepress_login_image', array(
            'label'       => __( 'Login Image', 'etalasepress' ),
            'description' => esc_html__( 'This image will be displayed on WordPress login page. Suggested image dimensions is 300 by 100 pixels.', 'etalasepress' ),
            'section'     => 'title_tagline',
            'flex_width'  => true,
            'flex_height' => true,
            'width'       => 300,
            'height'      => 100
        ) ) );
    }
    
    $wp_customize->add_section( 'etalasepress_settings', array(
        'title' => __( 'Theme Settings', 'etalasepress' )
    ) );
    
    $wp_customize->add_setting( 'etalasepress_color_scheme', array(
        'default'           => 'default',
        'sanitize_callback' => 'sanitize_text_field'
    ) );
    
    $wp_customize->add_control( 'etalasepress_color_scheme', array(
        'label'   => __( 'Color Scheme', 'etalasepress' ),
        'section' => 'etalasepress_settings',
        'type'    => 'select',
        'choices' => apply_filters( 'etalasepress_color_scheme_options_for_customizer', array(
            'default' => __( 'Default', 'etalasepress' )
        ) )
    ) );
    
    $wp_customize->add_setting( 'etalasepress_default_layout', array(
        'default'           => 'content-sidebar',
        'sanitize_callback' => 'sanitize_text_field'
    ) );
    
    $wp_customize->add_control( 'etalasepress_default_layout', array(
        'label'   => __( 'Default Layout', 'etalasepress' ),
        'section' => 'etalasepress_settings',
        'type'    => 'select',
        'choices' => array(
            'content-sidebar'    => __( 'Content - Sidebar', 'etalasepress' ),
            'sidebar-content'    => __( 'Sidebar - Content', 'etalasepress' ),
            'content'            => __( 'Content - No Sidebar', 'etalasepress' ),
            'full-width-content' => __( 'Full Width Content', 'etalasepress' )
        )
    ) );

    $wp_customize->add_setting( 'etalasepress_custom_copyright_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field'
    ) );

    $wp_customize->add_control( 'etalasepress_custom_copyright_text', array(
        'label'   => __( 'Custom Copyright Text', 'etalasepress' ),
        'section' => 'etalasepress_settings',
        'type'    => 'textarea',
    ) );
}

add_action( 'customize_register', 'etalasepress_customize_register' );
