<?php
function etalasepress_settings_admin_menu() {
    add_theme_page( __( 'Theme Settings', 'etalasepress' ), __( 'Theme Settings', 'etalasepress' ), 'manage_options', 'etalasepress-settings', 'etalasepress_settings_page' );
}

add_action( 'admin_menu', 'etalasepress_settings_admin_menu' );

function etalasepress_settings_page() {
    $modules = etalasepress_get_modules();
    ?>
    <div class="wrap">
        <h2><?php _e( 'Theme Settings', 'etalasepress' );?></h2>
        <form method="post" action="options.php">
            <?php settings_fields( 'etalasepress_options' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php echo esc_html__( 'License Key', 'etalasepress' );?></th>
                    <td class="forminp">
                        <input type="text" name="etalasepress_options[license_key]" value="<?php echo etalasepress_get_setting_value( 'license_key' ) ?>" class="regular-text">
                        <p class="description"><?php echo __( 'Activate your license key to receive automatic updates of your theme.', 'etalasepress' ) ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php echo esc_html__( 'Google Analytics ID', 'etalasepress' );?></th>
                    <td class="forminp">
                        <input type="text" name="etalasepress_options[google_analytics_id]" value="<?php echo etalasepress_get_setting_value( 'google_analytics_id' ) ?>" class="regular-text" placeholder="<?php echo __( 'Example: UA-12345678-5', 'etalasepress' ) ?>">
                        <p class="description"><?php echo __( 'Google Analytics ID is the identifier associated with your account and used by Google Analytics to collect the data.', 'etalasepress' ) ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php echo esc_html__( 'Modules', 'etalasepress' );?></th>
                    <td class="forminp">
                        <select name="etalasepress_options[modules][]" multiple="multiple" class="etalasepress-select">
                            <?php foreach ( $modules as $key => $module ): ?>
                            <option value="<?php echo esc_attr( $key ) ?>"<?php selected( in_array( $key, etalasepress_get_setting_value( 'modules' ) ) ) ?>><?php echo esc_html( $module ) ?></option>
                            <?php endforeach ?>
                        </select>
                    </td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" class="button-primary" value="<?php echo esc_attr__( 'Save Changes', 'etalasepress' ); ?>" />
            </p>
        </form>
    </div>
    <?php
}

function etalasepress_settings_init() {
    register_setting( 'etalasepress_options', 'etalasepress_options', 'etalasepress_settings_sanitize' );
}

add_action( 'admin_init', 'etalasepress_settings_init' );

function etalasepress_settings_sanitize( $input ) {
    $options  = get_option( 'etalasepress_options', etalasepress_default_settings() );
    $settings = etalasepress_settings();

    foreach ( $settings as $key => $setting ) {
        if ( 'text' === $setting['type'] ) {
            $options[$key] = esc_attr( $input[$key] );
        } elseif ( 'select' === $setting['type'] || 'radio' === $setting['type'] ) {
            if ( in_array( $input[$key], $setting['options'] ) ) {
                $options[$key] = $input[$key];
            } else {
                $options[$key] = $setting['default_value'];
            }
        } elseif ( 'multiple' === $setting['type'] ) {
            $valid_values = array();

            foreach ( $input[$key] as $val ) {
                if ( in_array( $val, $setting['options'] ) ) {
                    $valid_values[] = $val;
                }
            }

            $options[$key] = $valid_values;
        } elseif ( 'checkbox' === $setting['type'] ) {
            if ( isset( $input[$key] ) ) {
                $options[$key] = 'Y';
            } else {
                $options[$key] = 'N';
            }
        } else {
            $options[$key] = $input[$key];
        }
    }

    return $options;
}

function etalasepress_default_settings() {
    $default_settings = array();
    $settings = etalasepress_settings();

    foreach ( $settings as $key => $setting ) {
        $default_settings[$key] = $setting['default_value'];
    }
    
    return $default_settings;
}

function etalasepress_settings() {
    $settings = array(
        'license_key' => array(
            'type'          => 'text',
            'default_value' => ''
        ),
        'google_analytics_id' => array(
            'type'          => 'text',
            'default_value' => ''
        ),
        'modules' => array(
            'type'          => 'multiple',
            'default_value' => array( 'login-logo' ),
            'options'       => array_keys( etalasepress_get_modules() )
        )
    );
    
    return $settings;
}

function etalasepress_get_setting_value( $key = false ) {
    global $etalasepress_options;
    
    $default_settings = etalasepress_default_settings();
            
    if ( empty( $etalasepress_options ) ) {
        $etalasepress_options = get_option( 'etalasepress_options', $default_settings );
    }
    
    if ( isset( $etalasepress_options[$key] ) ) {
        return $etalasepress_options[$key];
    } elseif ( isset( $default_settings[$key] ) ) {
        return $default_settings[$key];
    } else {
        return false;
    }
}

function etalasepress_get_modules() {
    $modules = array(
        'login-logo'       => __( 'Login Logo', 'etalasepress' ),
        'custom-sidebar'   => __( 'Custom Sidebar', 'etalasepress' ),
        'mega-menu'        => __( 'Mega Menu', 'etalasepress' ),
        'post-type-layout' => __( 'Post Type Layout', 'etalasepress' ),
        'custom-label'     => __( 'Custom Label', 'etalasepress' ),
    );
    
    return apply_filters( 'etalasepress_modules', $modules );
}

function etalasepress_settings_admin_enqueue_scripts() {
    $screen = get_current_screen();
    
    if ( isset( $screen->base ) && 'appearance_page_etalasepress-settings' === $screen->base ) {
        wp_enqueue_script( 'jquery-select2',    get_template_directory_uri() . '/assets/js/select2.min.js', array( 'jquery' ) );
        wp_enqueue_script( 'etalasepress-settings', get_template_directory_uri() . '/assets/js/settings.js', array( 'jquery', 'jquery-select2' ) );
        
        wp_enqueue_style( 'jquery-select2',    get_template_directory_uri() . '/assets/css/select2.css' );
        wp_enqueue_style( 'etalasepress-settings', get_template_directory_uri() . '/assets/css/settings.css', array( 'jquery-select2' ) );
    }
}

add_action( 'admin_enqueue_scripts', 'etalasepress_settings_admin_enqueue_scripts' );