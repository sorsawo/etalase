<?php
function alamanda_settings_admin_menu() {
    add_theme_page( __( 'Theme Settings', 'alamanda' ), __( 'Theme Settings', 'alamanda' ), 'manage_options', 'alamanda-settings', 'alamanda_settings_page' );
}

add_action( 'admin_menu', 'alamanda_settings_admin_menu' );

function alamanda_settings_page() {
    $modules = alamanda_get_modules();
    ?>
    <div class="wrap">
        <h2><?php _e( 'Theme Settings', 'alamanda' );?></h2>
        <form method="post" action="options.php">
            <?php settings_fields( 'alamanda_options' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php echo esc_html__( 'License Key', 'alamanda' );?></th>
                    <td class="forminp">
                        <input type="text" name="alamanda_options[license_key]" value="<?php echo alamanda_get_setting_value( 'license_key' ) ?>" class="regular-text">
                        <p class="description"><?php echo __( 'Activate your license key to receive automatic updates of your theme.', 'alamanda' ) ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php echo esc_html__( 'Google Analytics ID', 'alamanda' );?></th>
                    <td class="forminp">
                        <input type="text" name="alamanda_options[google_analytics_id]" value="<?php echo alamanda_get_setting_value( 'google_analytics_id' ) ?>" class="regular-text" placeholder="<?php echo __( 'Example: UA-12345678-5', 'alamanda' ) ?>">
                        <p class="description"><?php echo __( 'Google Analytics ID is the identifier associated with your account and used by Google Analytics to collect the data.', 'alamanda' ) ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php echo esc_html__( 'Modules', 'alamanda' );?></th>
                    <td class="forminp">
                        <select name="alamanda_options[modules][]" multiple="multiple" class="alamanda-select">
                            <?php foreach ( $modules as $key => $module ): ?>
                            <option value="<?php echo esc_attr( $key ) ?>"<?php selected( in_array( $key, alamanda_get_setting_value( 'modules' ) ) ) ?>><?php echo esc_html( $module ) ?></option>
                            <?php endforeach ?>
                        </select>
                    </td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" class="button-primary" value="<?php echo esc_attr__( 'Save Changes', 'alamanda' ); ?>" />
            </p>
        </form>
    </div>
    <?php
}

function alamanda_settings_init() {
    register_setting( 'alamanda_options', 'alamanda_options', 'alamanda_settings_sanitize' );
}

add_action( 'admin_init', 'alamanda_settings_init' );

function alamanda_settings_sanitize( $input ) {
    $options  = get_option( 'alamanda_options', alamanda_default_settings() );
    $settings = alamanda_settings();

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

function alamanda_default_settings() {
    $default_settings = array();
    $settings = alamanda_settings();

    foreach ( $settings as $key => $setting ) {
        $default_settings[$key] = $setting['default_value'];
    }
    
    return $default_settings;
}

function alamanda_settings() {
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
            'options'       => array_keys( alamanda_get_modules() )
        )
    );
    
    return $settings;
}

function alamanda_get_setting_value( $key = false ) {
    global $alamanda_options;
    
    $default_settings = alamanda_default_settings();
            
    if ( empty( $alamanda_options ) ) {
        $alamanda_options = get_option( 'alamanda_options', $default_settings );
    }
    
    if ( isset( $alamanda_options[$key] ) ) {
        return $alamanda_options[$key];
    } elseif ( isset( $default_settings[$key] ) ) {
        return $default_settings[$key];
    } else {
        return false;
    }
}

function alamanda_get_modules() {
    $modules = array(
        'login-logo'       => __( 'Login Logo', 'alamanda' ),
        'custom-sidebar'   => __( 'Custom Sidebar', 'alamanda' ),
        'mega-menu'        => __( 'Mega Menu', 'alamanda' ),
        'post-type-layout' => __( 'Post Type Layout', 'alamanda' ),
        'custom-label'     => __( 'Custom Label', 'alamanda' ),
    );
    
    return apply_filters( 'alamanda_modules', $modules );
}

function alamanda_settings_admin_enqueue_scripts() {
    $screen = get_current_screen();
    
    if ( isset( $screen->base ) && 'appearance_page_alamanda-settings' === $screen->base ) {
        wp_enqueue_script( 'jquery-select2',    get_template_directory_uri() . '/assets/js/select2.min.js', array( 'jquery' ) );
        wp_enqueue_script( 'alamanda-settings', get_template_directory_uri() . '/assets/js/settings.js', array( 'jquery', 'jquery-select2' ) );
        
        wp_enqueue_style( 'jquery-select2',    get_template_directory_uri() . '/assets/css/select2.css' );
        wp_enqueue_style( 'alamanda-settings', get_template_directory_uri() . '/assets/css/settings.css', array( 'jquery-select2' ) );
    }
}

add_action( 'admin_enqueue_scripts', 'alamanda_settings_admin_enqueue_scripts' );