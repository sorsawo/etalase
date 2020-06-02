<?php

function alamanda_customize_register( $wp_customize ) {
    if ( in_array( 'login-logo', alamanda_get_setting_value( 'modules' ) ) ) {
        $wp_customize->add_setting( 'alamanda_login_image', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'alamanda_login_image', array(
            'label'       => __( 'Login Image', 'alamanda' ),
            'description' => esc_html__( 'This image will be displayed on WordPress login page. Suggested image dimensions is 300 by 100 pixels.', 'alamanda' ),
            'section'     => 'title_tagline',
            'flex_width'  => true,
            'flex_height' => true,
            'width'       => 300,
            'height'      => 100
        ) ) );
    }
    
    $wp_customize->add_section( 'alamanda_settings', array(
        'title' => __( 'Theme Settings', 'alamanda' )
    ) );
    
    $wp_customize->add_setting( 'alamanda_color_scheme', array(
        'default'           => 'default',
        'sanitize_callback' => 'sanitize_text_field'
    ) );
    
    $wp_customize->add_control( 'alamanda_color_scheme', array(
        'label'   => __( 'Color Scheme', 'alamanda' ),
        'section' => 'alamanda_settings',
        'type'    => 'select',
        'choices' => apply_filters( 'alamanda_color_scheme_options_for_customizer', array(
            'default' => __( 'Default', 'alamanda' )
        ) )
    ) );
    
    $wp_customize->add_setting( 'alamanda_default_layout', array(
        'default'           => 'content-sidebar',
        'sanitize_callback' => 'sanitize_text_field'
    ) );
    
    $wp_customize->add_control( 'alamanda_default_layout', array(
        'label'   => __( 'Default Layout', 'alamanda' ),
        'section' => 'alamanda_settings',
        'type'    => 'select',
        'choices' => array(
            'content-sidebar'    => __( 'Content - Sidebar', 'alamanda' ),
            'sidebar-content'    => __( 'Sidebar - Content', 'alamanda' ),
            'content'            => __( 'Content - No Sidebar', 'alamanda' ),
            'full-width-content' => __( 'Full Width Content', 'alamanda' )
        )
    ) );

    $wp_customize->add_setting( 'alamanda_custom_copyright_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field'
    ) );

    $wp_customize->add_control( 'alamanda_custom_copyright_text', array(
        'label'   => __( 'Custom Copyright Text', 'alamanda' ),
        'section' => 'alamanda_settings',
        'type'    => 'textarea',
    ) );
}

add_action( 'customize_register', 'alamanda_customize_register' );
