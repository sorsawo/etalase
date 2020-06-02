<?php

function etalasepress_customize_register( $wp_customize ) {
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
